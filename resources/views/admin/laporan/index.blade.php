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
    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-12">
            <div class="flex items-center gap-3 mb-2">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg" style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900">Laporan Penjualan</h1>
            </div>
            <p class="text-gray-600 ml-15">Analisis penjualan harian dan bulanan Warkop Anda</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Laporan Harian -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-shadow">
                <div class="px-6 py-4" style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);">
                    <h2 class="text-2xl font-bold text-white">Laporan Harian</h2>
                    <p class="text-white text-opacity-90 mt-1">Lihat laporan per hari</p>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('admin.laporan.harian') }}" method="GET" class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Tanggal</label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none" style="focus-visible: outline: 3px solid rgba(73, 149, 135, 0.1); border-color: #499587;" required>
                        </div>
                        <button type="submit" class="w-full text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200" style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(73, 149, 135, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            Lihat Laporan Harian
                        </button>
                    </form>
                </div>
            </div>

            <!-- Laporan Bulanan -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-shadow">
                <div class="px-6 py-4" style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);">
                    <h2 class="text-2xl font-bold text-white">Laporan Bulanan</h2>
                    <p class="text-white text-opacity-90 mt-1">Lihat laporan per bulan</p>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('admin.laporan.bulanan') }}" method="GET" class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Bulan</label>
                            <input type="month" name="bulan" value="{{ date('Y-m') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none" style="focus-visible: outline: 3px solid rgba(73, 149, 135, 0.1); border-color: #499587;" required>
                        </div>
                        <button type="submit" class="w-full text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200" style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(73, 149, 135, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            Lihat Laporan Bulanan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
