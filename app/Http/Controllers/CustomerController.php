<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Keranjang;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use App\Models\Notification;
use App\Models\User;

class CustomerController extends Controller
{
    public function dashboard()
    {
        // Ambil semua menu yang tersedia dengan category (hanya yang aktif)
        $menus = Menu::with('category')->where('is_active', true)->get();
        $categories = Category::all();
        $selectedCategory = request('category');

        if ($selectedCategory) {
            $menus = Menu::with('category')->where('category_id', $selectedCategory)->where('is_active', true)->get();
        }

        // Ambil data keranjang untuk ditampilkan di navbar
        $customer_name = session('customer_name');
        $keranjang = Keranjang::where('customer_name', $customer_name)->with('menu')->get();
        $cartCount = $keranjang->sum('qty');
        $cartTotal = $keranjang->sum(function($item) {
            return $item->menu->harga * $item->qty;
        });

        // Cek apakah pelanggan sudah memiliki pesanan untuk menampilkan tombol riwayat
        $hasOrders = Order::where('customer_name', $customer_name)->exists();

        return view('customer.dashboard', compact('menus', 'categories', 'selectedCategory', 'cartCount', 'cartTotal', 'hasOrders'));
    }

    public function addToCart(Request $request)
    {
        try {
            $customer_name = session('customer_name');
            
            // Check if customer_name exists in session
            if (!$customer_name) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session tidak valid. Silahkan login kembali.'
                ], 401);
            }
            
            $menu_id = $request->input('menu_id');
            
            if (!$menu_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Menu ID tidak valid'
                ], 400);
            }

            // Cek apakah item sudah ada di keranjang
            $existing = Keranjang::where('customer_name', $customer_name)
                                 ->where('menu_id', $menu_id)
                                 ->first();

            if ($existing) {
                // Jika sudah ada, tambah qty
                $existing->increment('qty');
            } else {
                // Jika belum ada, buat item baru
                Keranjang::create([
                    'customer_name' => $customer_name,
                    'menu_id' => $menu_id,
                    'qty' => 1
                ]);
            }

            // Get updated cart info
            $cartItems = Keranjang::where('customer_name', $customer_name)->with('menu')->get();
            $cartCount = $cartItems->sum('qty');
            $cartTotal = $cartItems->sum(function($item) {
                return $item->menu->harga * $item->qty;
            });

            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil ditambahkan ke keranjang',
                'cartCount' => $cartCount,
                'cartTotal' => $cartTotal
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showCart()
    {
        $keranjang = Keranjang::where('customer_name', session('customer_name'))->with('menu')->get();

        return view('customer.keranjang', compact('keranjang'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:tunai,qris'
        ]);

        $customer_name = session('customer_name');
        $user_id = session('user_id');
        $meja_id = session('meja_id');
        
        // Ambil semua item keranjang
        $keranjang = Keranjang::where('customer_name', $customer_name)->with('menu')->get();

        if ($keranjang->isEmpty()) {
            return back()->with('error', 'Keranjang kosong!');
        }

        // Hitung total harga
        $total_harga = $keranjang->sum(function ($item) {
            return $item->menu->harga * $item->qty;
        });

        // Status pembayaran otomatis lunas jika QRIS
        $status_pembayaran = $request->metode_pembayaran === 'qris' ? 'lunas' : 'belum_bayar';

        // Buat order baru
        $order = Order::create([
            'user_id' => $user_id,
            'customer_name' => $customer_name,
            'nomor_meja' => $meja_id,
            'total_harga' => $total_harga,
            'status' => 'menunggu',
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => $status_pembayaran
        ]);

        // Pindahkan item keranjang ke order_items
        foreach ($keranjang as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item->menu_id,
                'qty' => $item->qty,
                'harga' => $item->menu->harga,
                'catatan' => $request->input('catatan_' . $item->id)
            ]);
        }

        // Hapus semua item dari keranjang
        Keranjang::where('customer_name', $customer_name)->delete();

        return redirect()->route('customer.order-history')->with('success', 'Pesanan berhasil dibuat! Pesanan sedang diproses.');
    }

    public function getRecentOrders(Request $request)
    {
        $customer_name = session('customer_name');
        $limit = $request->input('limit', 5); // Default 5 orders
        
        $orders = Order::where('customer_name', $customer_name)
            ->with('items.menu')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'orders' => $orders->map(function($order) {
                return [
                    'id' => $order->id,
                    'nomor_meja' => $order->nomor_meja,
                    'status' => $order->status,
                    'metode_pembayaran' => $order->metode_pembayaran,
                    'status_pembayaran' => $order->status_pembayaran,
                    'total_harga' => $order->total_harga,
                    'created_at' => $order->created_at->format('d M Y H:i'),
                    'items_count' => $order->items->count(),
                ];
            })
        ]);
    }

    public function orderHistory()
    {
        $customer_name = session('customer_name');
        $orders = Order::where('customer_name', $customer_name)->with('items.menu')->orderBy('created_at', 'desc')->get();

        return view('customer.order-history', compact('orders'));
    }

    public function orderDetail($order_id)
    {
        $customer_name = session('customer_name');
        $order = Order::where('customer_name', $customer_name)->with('items.menu')->findOrFail($order_id);

        return view('customer.order-detail', compact('order'));
    }

    public function deleteFromCart($id)
    {
        Keranjang::findOrFail($id)->delete();
        return back()->with('success', 'Item berhasil dihapus dari keranjang');
    }

    public function updateQty(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        try {
            $item = Keranjang::findOrFail($id);
            $item->update(['qty' => (int) $request->qty]);

            // Recalculate totals
            $customer_name = session('customer_name');
            $cartItems = Keranjang::where('customer_name', $customer_name)->with('menu')->get();
            $cartCount = $cartItems->sum('qty');
            $cartTotal = $cartItems->sum(function($ci) { return $ci->menu->harga * $ci->qty; });
            $itemSubtotal = $item->menu->harga * $item->qty;

            // When request expects JSON (AJAX), return JSON
            if ($request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => true,
                    'message' => 'Jumlah item diperbarui',
                    'itemId' => $item->id,
                    'qty' => $item->qty,
                    'itemSubtotal' => $itemSubtotal,
                    'cartCount' => $cartCount,
                    'cartTotal' => $cartTotal,
                ]);
            }

            return back()->with('success', 'Jumlah item berhasil diperbarui');
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage(),
                ], 500);
            }
            return back()->with('error', 'Terjadi kesalahan saat memperbarui jumlah item');
        }
    }

    public function downloadReceipt($order_id)
    {
        $customer_name = session('customer_name');
        $order = Order::where('customer_name', $customer_name)->with('items.menu')->findOrFail($order_id);

        $pdf = \PDF::loadView('customer.receipt-pdf', compact('order'));
        return $pdf->download('receipt_'.$order->id.'.pdf');
    }

    // Notifikasi API
    public function getNotificationsAPI()
    {
        $user_id = session('user_id');
        if (!$user_id) {
            return response()->json(['notifications' => []]);
        }

        $notifications = Notification::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json(['notifications' => $notifications]);
    }

    // Halaman notifikasi
    public function getNotifications()
    {
        $user_id = session('user_id');
        if (!$user_id) {
            return redirect('/login-customer');
        }

        $notifications = Notification::where('user_id', $user_id)
            ->with('order')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.notifications', compact('notifications'));
    }

    // Mark notification as read
    public function markNotificationAsRead(Notification $notification)
    {
        $user_id = session('user_id');
        if ($user_id == $notification->user_id) {
            $notification->markAsRead();
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error'], 403);
    }
}
