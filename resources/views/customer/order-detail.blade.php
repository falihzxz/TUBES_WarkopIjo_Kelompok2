@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
    <!-- Back Link -->
    <div class="mb-6">
        <a href="{{ route('customer.order-history') }}" class="inline-flex items-center gap-2 text-custom-green font-semibold hover:opacity-80 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Riwayat Pesanan
        </a>
    </div>

    <!-- Header -->
    <div class="mb-8 pt-2">
        <h1 class="text-4xl font-black mb-2" style="color:#499587">Detail Pesanan #{{ $order->id }}</h1>
        <p class="text-gray-600">Lihat informasi lengkap pesanan Anda</p>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Order Details -->
        <div class="lg:col-span-2">
            <!-- Order Info Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Pesanan</h3>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Nama Pelanggan</p>
                        <p class="text-lg font-bold text-gray-900">{{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Nomor Meja</p>
                        <p class="text-lg font-bold text-gray-900">{{ $order->nomor_meja }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Tanggal & Waktu</p>
                        <p class="text-lg font-bold text-gray-900">{{ $order->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Status Pesanan</p>
                        @php
                            $statusColor = match($order->status) {
                                'menunggu' => ['bg' => 'rgba(234, 179, 8, 0.12)', 'text' => '#b45309'],
                                'diproses' => ['bg' => 'rgba(59, 130, 246, 0.12)', 'text' => '#1d4ed8'],
                                'siap' => ['bg' => 'rgba(16, 185, 129, 0.12)', 'text' => '#059669'],
                                'selesai' => ['bg' => 'rgba(73,149,135,0.12)', 'text' => '#499587'],
                                default => ['bg' => 'rgba(107,114,128,0.12)', 'text' => '#374151']
                            };
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold" style="background-color: {{ $statusColor['bg'] }}; color: {{ $statusColor['text'] }};">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Items Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-lg text-gray-900">Daftar Item</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($order->items as $item)
                    <div class="px-6 py-4 hover:bg-gray-50 transition">
                        <div class="flex items-start justify-between gap-4 mb-2">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 text-base">{{ $item->menu->nama }}</p>
                                <p class="text-sm text-gray-500">{{ $item->qty }} x Rp {{ number_format($item->harga) }}</p>
                                @if($item->catatan)
                                    <p class="text-sm text-gray-600 mt-2 italic">Catatan: {{ $item->catatan }}</p>
                                @endif
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="font-bold" style="color:#499587">Rp {{ number_format($item->harga * $item->qty) }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Column: Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-32">
                <!-- Totals -->
                <div class="space-y-3 mb-6 pb-6 border-b border-gray-100">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold text-gray-900">Rp {{ number_format($order->total_harga) }}</span>
                    </div>
                </div>

                <!-- Total Card -->
                <div class="bg-gradient-to-br from-custom-green/10 to-custom-green/5 rounded-xl p-4 mb-6 border border-custom-green/20">
                    <p class="text-xs text-gray-600 mb-1 uppercase font-semibold">Total Belanja</p>
                    <h2 class="text-3xl font-black" style="color:#499587">
                        Rp {{ number_format($order->total_harga) }}
                    </h2>
                </div>

                <!-- Payment Info -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <p class="text-xs text-gray-600 uppercase font-semibold mb-2">Metode Pembayaran</p>
                    <p class="text-sm font-semibold text-gray-900 mb-3">{{ strtoupper($order->metode_pembayaran) }}</p>
                    @if(isset($order->status_pembayaran))
                        <p class="text-xs text-gray-600 uppercase font-semibold mb-1">Status Pembayaran</p>
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold" style="background-color: {{ $order->status_pembayaran === 'lunas' ? 'rgba(16,185,129,0.12)' : 'rgba(239,68,68,0.12)' }}; color: {{ $order->status_pembayaran === 'lunas' ? '#059669' : '#dc2626' }};">
                            {{ str_replace('_', ' ', ucfirst($order->status_pembayaran)) }}
                        </span>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <a href="{{ route('customer.order.receipt', $order->id) }}" class="w-full text-center text-white font-semibold py-2 rounded-lg transition inline-flex items-center justify-center gap-2" style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2m0 0v-8m0 8H3m15 0h3" />
                        </svg>
                        Cetak Receipt
                    </a>
                    <a href="{{ route('customer.dashboard') }}" class="w-full text-center text-white font-semibold py-2 rounded-lg transition inline-block" style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);">
                        Pesan Lagi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
