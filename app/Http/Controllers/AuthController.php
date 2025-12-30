<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\Meja;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // --- Admin ---
    public function showLoginAdmin(){
        return view('auth.login-admin');
    }

    public function loginAdmin(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $admin = Admin::where('username',$request->username)->first();
        if($admin && Hash::check($request->password, $admin->password)){
            session(['admin_id' => $admin->id]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['username'=>'Username atau password salah']);
    }

    public function logoutAdmin(){
        session()->forget('admin_id');
        return redirect('/login-admin');
    }

    // --- Customer ---
    public function showRegisterCustomer(){
        return view('auth.register-customer');
    }

    public function registerCustomer(Request $request){
        $request->validate([
            'name' => 'required|string|min:3',
            'username' => 'required|string|unique:users|min:3|regex:/^[a-zA-Z0-9_]+$/',
            'email' => 'nullable|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'username.regex' => 'Username hanya boleh berisi huruf, angka, dan underscore',
            'username.unique' => 'Username sudah digunakan',
            'password.confirmed' => 'Password tidak cocok',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login-customer')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    public function showLoginCustomer(){
        return view('auth.login-customer');
    }

    public function loginCustomer(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();
        if($user && Hash::check($request->password, $user->password)){
            session([
                'user_id' => $user->id,
                'customer_name' => $user->name,
                'username' => $user->username
            ]);

            // Jika punya pesanan aktif, langsung pakai meja yang sama dan skip pilih meja
            $activeOrder = Order::where('customer_name', $user->name)
                ->whereIn('status', ['menunggu','diproses','siap'])
                ->latest()
                ->first();

            if($activeOrder && $activeOrder->nomor_meja){
                session(['meja_id' => $activeOrder->nomor_meja]);
                return redirect()->route('customer.dashboard');
            }

            return redirect()->route('customer.select-meja');
        }

        return back()->withErrors(['username'=>'Username atau password salah']);
    }

    public function showSelectMeja(){
        // Jika user punya pesanan aktif, langsung arahkan ke dashboard
        $customer_name = session('customer_name');
        $activeOrder = Order::where('customer_name', $customer_name)
            ->whereIn('status', ['menunggu','diproses','siap'])
            ->latest()
            ->first();
        if($activeOrder && $activeOrder->nomor_meja){
            session(['meja_id' => $activeOrder->nomor_meja]);
            return redirect()->route('customer.dashboard');
        }

        $mejas = Meja::orderBy('nomor_meja')->get();
        // Meja dianggap terpakai jika ada order aktif (menunggu/diproses/siap)
        $occupiedMejaIds = Order::whereIn('status', ['menunggu','diproses','siap'])
            ->pluck('nomor_meja')
            ->filter()
            ->values()
            ->toArray();
        return view('auth.select-meja', compact('mejas', 'occupiedMejaIds'));
    }

    public function selectMeja(Request $request){
        $request->validate([
            'meja_id' => 'required|exists:mejas,id'
        ]);

        $meja = Meja::findOrFail($request->meja_id);
        // Blok jika meja tidak tersedia atau ada order aktif di meja tsb
        $hasActiveOrder = Order::whereIn('status', ['menunggu','diproses','siap'])
            ->where('nomor_meja', $meja->id)
            ->exists();
        if($meja->status !== 'tersedia' || $hasActiveOrder){
            return back()->withErrors(['meja_id' => 'Meja ini tidak tersedia']);
        }

        session(['meja_id' => $request->meja_id]);
        $meja->status = 'dipakai';
        $meja->save();

        return redirect()->route('customer.dashboard');
    }

    public function logoutCustomer(){
        // Jangan otomatis membebaskan meja saat logout.
        // Meja tetap 'dipakai' hingga admin menandai tersedia.
        session()->forget(['user_id', 'customer_name', 'username', 'meja_id']);
        return redirect('/login-customer');
    }

    // --- Forgot Password ---
    public function showForgotPassword(){
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request){
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();
        $token = Str::random(60);

        \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => Hash::make($token), 'created_at' => now()]
        );

        // Kirim email dengan link reset
        $resetUrl = url('/reset-password?token='.$token.'&email='.$request->email);
        
        Mail::send('emails.reset-password', ['resetUrl' => $resetUrl, 'user' => $user], function($message) use ($user) {
            $message->to($user->email, $user->name)
                ->subject('Reset Password - Warkop Ijo');
        });

        return back()->with('status', 'Link reset password telah dikirim ke email Anda!');
    }

    public function showResetForm(Request $request){
        return view('auth.reset-password', [
            'token' => $request->token,
            'email' => $request->email
        ]);
    }

    public function resetPassword(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $resetRecord = \DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors(['email' => 'Token reset password tidak valid atau sudah kadaluarsa.']);
        }

        // Update password user
        $user = User::where('email', $request->email)->first();
        $user->update(['password' => Hash::make($request->password)]);

        // Hapus token reset
        \DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('/login-customer')->with('status', 'Password berhasil direset! Silakan login dengan password baru.');
    }
}
