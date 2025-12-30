@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Header -->
    <div class="mb-10 pt-4">
        <h1 class="text-4xl font-black leading-snug mb-4 pb-1" style="background: linear-gradient(to right, #499587, #5aa897); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Riwayat Pesanan</h1>
        <p class="text-gray-600">Lihat pesanan Anda dan statusnya</p>
    </div>

    @if($orders->count() == 0)
        <!-- Empty State -->
        <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-gray-200">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Pesanan</h3>
            <p class="text-gray-600 mb-6">Ayo mulai pesan menu favoritmu sekarang</p>
            <a href="{{ route('customer.dashboard') }}" class="inline-block text-white px-8 py-3 rounded-lg font-semibold transition" style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);">
                Mulai Pesan
            </a>
        </div>
    @else
        <!-- Filters -->
        <div class="mb-6 flex flex-wrap gap-2">
            <button data-filter="all" class="px-3 py-2 text-sm font-semibold rounded-lg border border-gray-300 text-gray-700 hover:border-gray-400">Semua</button>
            <button data-filter="menunggu" class="px-3 py-2 text-sm font-semibold rounded-lg border border-gray-300 text-gray-700 hover:border-gray-400">Menunggu</button>
            <button data-filter="diproses" class="px-3 py-2 text-sm font-semibold rounded-lg border border-gray-300 text-gray-700 hover:border-gray-400">Diproses</button>
            <button data-filter="siap" class="px-3 py-2 text-sm font-semibold rounded-lg border border-gray-300 text-gray-700 hover:border-gray-400">Siap</button>
            <button data-filter="selesai" class="px-3 py-2 text-sm font-semibold rounded-lg border border-gray-300 text-gray-700 hover:border-gray-400">Selesai</button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($orders as $order)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition" data-status="{{ $order->status }}">
                <!-- Header -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="inline-flex items-center justify-center w-10 h-10 rounded-lg" style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18M3 7h18M9 11h10M9 15h10M9 19h10" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Pesanan #{{ $order->id }}</h3>
                            <p class="text-sm text-gray-600">Meja: {{ $order->nomor_meja }}</p>
                            <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    <div>
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

                <!-- Items -->
                <div class="border-t border-b py-4 mb-4">
                    <p class="text-sm text-gray-600 mb-3 font-semibold">Ringkasan Pesanan</p>
                    <div class="space-y-2">
                        @foreach($order->items as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-900 font-medium">{{ $item->menu->nama }} <span class="text-gray-500">x{{ $item->qty }}</span></span>
                            <span class="text-gray-600">Rp {{ number_format($item->harga * $item->qty) }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-600">Total</p>
                        <p class="text-2xl font-black" style="color:#499587">Rp {{ number_format($order->total_harga) }}</p>
                        <p class="text-xs text-gray-500 mt-1">Pembayaran: {{ strtoupper($order->metode_pembayaran) }} @if(isset($order->status_pembayaran)) • {{ str_replace('_',' ', ucfirst($order->status_pembayaran)) }} @endif</p>
                    </div>
                    <a href="{{ route('customer.order-detail', $order->id) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-white font-semibold rounded-lg transition" style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    <div class="mt-10">
        <a href="{{ route('customer.dashboard') }}" class="block w-full text-center border-2 border-gray-300 text-gray-700 font-semibold py-3 rounded-lg hover:border-gray-400 transition">
            Kembali Belanja
        </a>
    </div>
</div>

<script>
// Simple client-side filter
document.addEventListener('DOMContentLoaded', function() {
  const buttons = document.querySelectorAll('[data-filter]');
  const cards = document.querySelectorAll('[data-status]');
  buttons.forEach(btn => {
    btn.addEventListener('click', () => {
      const filter = btn.getAttribute('data-filter');
      buttons.forEach(b => b.classList.remove('ring-2','ring-offset-1'));
      btn.classList.add('ring-2','ring-offset-1');
      cards.forEach(card => {
        const status = card.getAttribute('data-status');
        card.style.display = (filter === 'all' || filter === status) ? '' : 'none';
      });
    });
  });
});
</script>
@endsection
