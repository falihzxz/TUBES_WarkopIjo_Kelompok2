@extends('layouts.app')

@section('content')
<!-- Back Button -->
<a href="{{ route('admin.laporan.index') }}" class="fixed top-6 left-6 inline-flex items-center gap-x-2 text-lg font-semibold transition-colors z-10" style="color: #499587;" onmouseover="this.style.color='#3a7a6f'" onmouseout="this.style.color='#499587'">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
    Kembali
</a>

<div class="min-h-screen bg-white" style="padding-top: 40px;">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-12">
            <div>
                <h1 class="text-4xl font-bold text-gray-900">Laporan Bulanan</h1>
                <p class="text-gray-600 mt-2">Periode: <span class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($bulan . '-01')->format('F Y') }}</span></p>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-lg hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Pesanan</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $total_pesanan }}</p>
                    </div>
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg" style="background-color: rgba(73, 149, 135, 0.1);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" style="color: #499587;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-lg hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Pendapatan</p>
                        <p class="text-3xl font-bold mt-2" style="color: #499587;">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</p>
                    </div>
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg" style="background-color: rgba(73, 149, 135, 0.1);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" style="color: #499587;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-lg hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Rata-rata per Pesanan</p>
                        <p class="text-3xl font-bold mt-2" style="color: #499587;">Rp {{ $total_pesanan > 0 ? number_format($total_pendapatan / $total_pesanan, 0, ',', '.') : 0 }}</p>
                    </div>
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg" style="background-color: rgba(73, 149, 135, 0.1);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" style="color: #499587;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

    <!-- Payment Method Breakdown -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        @php
            $tunai_count = $orders->where('metode_pembayaran', 'tunai')->count();
            $qris_count = $orders->where('metode_pembayaran', 'qris')->count();
            $tunai_total = $orders->where('metode_pembayaran', 'tunai')->sum('total_harga');
            $qris_total = $orders->where('metode_pembayaran', 'qris')->sum('total_harga');
        @endphp
        
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-lg hover:shadow-xl transition-shadow">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Pembayaran Tunai</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <span class="text-gray-600">Jumlah Transaksi:</span>
                        <span class="font-bold text-gray-900 text-lg">{{ $tunai_count }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Pendapatan:</span>
                        <span class="font-bold text-lg" style="color: #499587;">Rp {{ number_format($tunai_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-lg hover:shadow-xl transition-shadow">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Pembayaran QRIS</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <span class="text-gray-600">Jumlah Transaksi:</span>
                        <span class="font-bold text-gray-900 text-lg">{{ $qris_count }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Pendapatan:</span>
                        <span class="font-bold text-lg" style="color: #499587;">Rp {{ number_format($qris_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4" style="background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%); border-bottom: 2px solid #e5e7eb;">
                <h2 class="text-xl font-bold text-gray-900">Detail Pesanan Bulanan</h2>
            </div>
            
            @if($orders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr style="background: linear-gradient(135deg, #f3f4f6 0%, #f9fafb 100%);">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">ID Pesanan</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Pelanggan</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Meja</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Metode</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $order->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $order->customer_name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $order->nomor_meja }}</td>
                                <td class="px-6 py-4 text-sm font-semibold" style="color: #499587;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold" style="background-color: {{ $order->metode_pembayaran === 'qris' ? 'rgba(59, 130, 246, 0.1)' : 'rgba(34, 197, 94, 0.1)' }}; color: {{ $order->metode_pembayaran === 'qris' ? '#1e40af' : '#15803d' }};">
                                        {{ strtoupper($order->metode_pembayaran) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold text-white
                                        @if($order->status === 'selesai') bg-green-500
                                        @elseif($order->status === 'siap') bg-blue-500
                                        @elseif($order->status === 'diproses') bg-orange-500
                                        @else bg-gray-500
                                        @endif">
                                        {{ strtoupper($order->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4" style="background-color: rgba(73, 149, 135, 0.1);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" style="color: #499587;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <p class="text-gray-600 text-lg font-semibold">Tidak ada pesanan pada bulan ini</p>
                </div>
            @endif
        </div>

        <!-- Print Button -->
        <div class="mt-8 flex justify-end">
            <button onclick="window.print()" class="inline-flex items-center justify-center gap-2 px-6 py-3 text-white font-semibold rounded-lg transition-all duration-200" style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(73, 149, 135, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4H7a2 2 0 01-2-2v-4a2 2 0 012-2h10a2 2 0 012 2v4a2 2 0 01-2 2zm0 0h6" />
                </svg>
                Cetak Laporan
            </button>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print {
            display: none !important;
        }
        button {
            display: none !important;
        }
        a {
            display: none !important;
        }
    }
</style>
@endsection
