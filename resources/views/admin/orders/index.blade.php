@extends('layouts.app')

@section('content')
<!-- Back Button -->
<a href="{{ route('admin.dashboard') }}" class="fixed top-6 left-6 inline-flex items-center gap-x-2 text-lg font-semibold transition-colors z-10" style="color: #499587;" onmouseover="this.style.color='#3a7a6f'" onmouseout="this.style.color='#499587'">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
    Kembali
</a>

<div class="min-h-screen bg-white" style="padding-top: 40px;">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-12">
            <div class="flex items-center gap-3 mb-2">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg" style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900">Daftar Pesanan</h1>
            </div>
            <p class="text-gray-600 ml-15">Kelola dan pantau semua pesanan masuk</p>
        </div>

        <!-- Success Message -->
        @if($message = Session::get('success'))
            <div class="mb-8 p-4 bg-green-50 border-l-4 rounded-lg" style="border-left-color: #499587;">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-green-700 font-semibold">{{ $message }}</p>
                </div>
            </div>
        @endif

        <!-- Empty State -->
        @if($orders->count() == 0)
            <div class="rounded-xl border border-gray-200 bg-white p-12 text-center shadow-sm">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4" style="background-color: rgba(73, 149, 135, 0.1);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" style="color: #499587;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Belum Ada Pesanan</h3>
                <p class="text-gray-600">Saat ini tidak ada pesanan yang masuk</p>
            </div>
        @else
            <div class="space-y-6">
            @foreach($orders as $order)
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-shadow">
                <!-- Header -->
                <div class="px-6 py-5 border-b border-gray-200" style="background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Pesanan #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h3>
                            <div class="mt-2 grid grid-cols-3 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-600">Pelanggan</p>
                                    <p class="font-semibold text-gray-900">{{ $order->customer_name }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Meja</p>
                                    <p class="font-semibold text-gray-900">{{ $order->nomor_meja }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Waktu Pesanan</p>
                                    <p class="font-semibold text-gray-900">{{ $order->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-600 text-sm mb-3">Status Pesanan</p>
                            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" 
                                    class="px-4 py-2 rounded-lg font-semibold text-white cursor-pointer text-sm transition-all
                                        @if($order->status === 'menunggu') bg-orange-500 hover:bg-orange-600
                                        @elseif($order->status === 'diproses') bg-blue-500 hover:bg-blue-600
                                        @elseif($order->status === 'siap') bg-green-500 hover:bg-green-600
                                        @else bg-gray-500 hover:bg-gray-600
                                        @endif
                                    ">
                                    <option value="menunggu" {{ $order->status === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="diproses" {{ $order->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="siap" {{ $order->status === 'siap' ? 'selected' : '' }}>Siap</option>
                                    <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Items -->
                <div class="px-6 py-5 border-b border-gray-200">
                    <p class="text-sm font-semibold text-gray-700 mb-4">Item Pesanan:</p>
                    <div class="space-y-3">
                        @foreach($order->items as $item)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">{{ $item->menu->nama }}</p>
                                <p class="text-sm text-gray-600 mt-1">{{ $item->qty }}x @ Rp {{ number_format($item->harga) }}</p>
                            </div>
                            <p class="font-semibold text-lg" style="color: #499587;">Rp {{ number_format($item->harga * $item->qty) }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pembayaran -->
                <div class="px-6 py-5 border-b border-gray-200" style="background-color: rgba(73, 149, 135, 0.05);">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Metode Pembayaran:</p>
                            <p class="font-semibold text-lg text-gray-900">{{ strtoupper($order->metode_pembayaran) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600 mb-1">Status Pembayaran:</p>
                            <span class="inline-block px-3 py-1 rounded-full font-semibold text-white text-sm
                                {{ $order->status_pembayaran === 'lunas' ? 'bg-green-500' : 'bg-orange-500' }}">
                                {{ $order->status_pembayaran === 'lunas' ? 'LUNAS' : 'BELUM BAYAR' }}
                            </span>
                        </div>
                    </div>
                    @if($order->metode_pembayaran === 'tunai' && $order->status_pembayaran === 'belum_bayar')
                    <form action="{{ route('admin.orders.confirm-payment', $order->id) }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="w-full text-white px-4 py-2 rounded-lg font-semibold transition-all duration-200" style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(73, 149, 135, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            Konfirmasi Pembayaran Tunai
                        </button>
                    </form>
                    @endif
                </div>

                <!-- Total dan Aksi -->
                <div class="px-6 py-5 flex justify-between items-center">
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Total Pesanan:</p>
                        <p class="text-3xl font-bold" style="color: #499587;">Rp {{ number_format($order->total_harga) }}</p>
                    </div>
                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center gap-1 px-4 py-2 text-sm font-semibold rounded-lg transition-all duration-200" style="color: #dc2626; background-color: rgba(220, 38, 38, 0.1); border: 1px solid rgba(220, 38, 38, 0.2);" onmouseover="this.style.backgroundColor='rgba(220, 38, 38, 0.15)'" onmouseout="this.style.backgroundColor='rgba(220, 38, 38, 0.1)'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @endif

    </div>
</div>

@endsection
