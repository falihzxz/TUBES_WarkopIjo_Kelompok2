<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Meja;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.menu')->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,siap,selesai'
        ]);

        $order->update(['status' => $request->status]);

        if ($request->status === 'selesai' && $order->nomor_meja) {
            $meja = Meja::find($order->nomor_meja);
            if ($meja) {
                $meja->update(['status' => 'tersedia']);
            }
        }

        // Kirim email notifikasi jika pesanan selesai dan user memiliki email
        if ($request->status === 'selesai') {
            $order->load('items.menu', 'user');
            $user = $order->user ?: User::where('name', $order->customer_name)->first();
            if ($user && $user->email) {
                Mail::send('emails.order-completed', ['order' => $order], function($message) use ($user, $order) {
                    $message->to($user->email, $user->name)
                        ->subject('Pesanan #' . $order->id . ' Selesai');
                });

                // Buat notifikasi UI di dashboard
                Notification::create([
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'type' => 'order_completed',
                    'title' => 'Pesanan Selesai',
                    'message' => 'Pesanan #' . $order->id . ' Anda sudah siap diambil!',
                ]);
            }
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui');
    }

    public function destroy(Order $order)
    {
        if ($order->nomor_meja) {
            $meja = Meja::find($order->nomor_meja);
            if ($meja) {
                $meja->update(['status' => 'tersedia']);
            }
        }
        $order->delete();
        return back()->with('success', 'Pesanan berhasil dihapus');
    }

    public function confirmPayment(Order $order)
    {
        if ($order->metode_pembayaran === 'tunai' && $order->status_pembayaran === 'belum_bayar') {
            $order->update(['status_pembayaran' => 'lunas']);
            return back()->with('success', 'Pembayaran berhasil dikonfirmasi');
        }

        return back()->with('error', 'Pembayaran sudah lunas atau metode pembayaran bukan tunai');
    }

    public function laporan()
    {
        return view('admin.laporan.index');
    }

    public function laporanHarian(Request $request)
    {
        $tanggal = $request->input('tanggal', date('Y-m-d'));
        
        $orders = Order::whereDate('created_at', $tanggal)
                        ->where('status_pembayaran', 'lunas')
                        ->with('items.menu')
                        ->get();

        $total_pendapatan = $orders->sum('total_harga');
        $total_pesanan = $orders->count();

        return view('admin.laporan.harian', compact('orders', 'total_pendapatan', 'total_pesanan', 'tanggal'));
    }

    public function laporanBulanan(Request $request)
    {
        $bulan = $request->input('bulan', date('Y-m'));
        
        $orders = Order::whereYear('created_at', date('Y', strtotime($bulan)))
                        ->whereMonth('created_at', date('m', strtotime($bulan)))
                        ->where('status_pembayaran', 'lunas')
                        ->with('items.menu')
                        ->get();

        $total_pendapatan = $orders->sum('total_harga');
        $total_pesanan = $orders->count();

        return view('admin.laporan.bulanan', compact('orders', 'total_pendapatan', 'total_pesanan', 'bulan'));
    }
}
