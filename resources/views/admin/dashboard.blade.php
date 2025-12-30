@extends('layouts.app')

@section('content')
@php
    $totalMeja = max($mejaCount, 1); // avoid division by zero
    $mejaDipakaiPct = round(($mejaDipakai / $totalMeja) * 100);
    $mejaTersediaPct = 100 - $mejaDipakaiPct;
@endphp

<div class="max-w-7xl mx-auto px-4 py-8 space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">Dashboard Admin</h1>
            <p class="text-gray-600 mt-2">Selamat datang, kelola restoran Anda dengan efisien</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 rounded-lg border-2 px-4 py-2 text-sm font-semibold transition-all duration-200" style="border-color: #499587; color: #499587;" onmouseover="this.style.backgroundColor='rgba(73, 149, 135, 0.05)'" onmouseout="this.style.backgroundColor='transparent'">
                <span>Halaman Utama</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition-shadow">
            <p class="text-sm text-gray-500">Total Menu</p>
            <div class="mt-2 flex items-end justify-between">
                <span class="text-3xl font-semibold" style="color: #499587;">{{ $menuCount }}</span>
                <a href="{{ route('admin.menu.index') }}" class="text-sm font-medium transition-colors" style="color: #499587;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Lihat</a>
            </div>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition-shadow">
            <p class="text-sm text-gray-500">Total Meja</p>
            <div class="mt-2 flex items-end justify-between">
                <span class="text-3xl font-semibold" style="color: #499587;">{{ $mejaCount }}</span>
                <a href="{{ route('admin.meja.index') }}" class="text-sm font-medium transition-colors" style="color: #499587;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Kelola</a>
            </div>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition-shadow">
            <p class="text-sm text-gray-500">Meja Tersedia</p>
            <div class="mt-2 flex items-end justify-between">
                <span class="text-3xl font-semibold text-green-600">{{ $mejaTersedia }}</span>
                <span class="text-sm text-gray-500">{{ $mejaTersediaPct }}%</span>
            </div>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition-shadow">
            <p class="text-sm text-gray-500">Meja Dipakai</p>
            <div class="mt-2 flex items-end justify-between">
                <span class="text-3xl font-semibold text-red-600">{{ $mejaDipakai }}</span>
                <span class="text-sm text-gray-500">{{ $mejaDipakaiPct }}%</span>
            </div>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition-shadow">
            <p class="text-sm text-gray-500">Pesanan Menunggu</p>
            <div class="mt-2 flex items-end justify-between">
                <span class="text-3xl font-semibold text-orange-600">{{ $orderMenunggu }}</span>
                <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium transition-colors text-orange-600" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Tinjau</a>
            </div>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition-shadow">
            <p class="text-sm text-gray-500">Total Pesanan</p>
            <div class="mt-2 flex items-end justify-between">
                <span class="text-3xl font-semibold text-gray-900">{{ $orderCount }}</span>
                <span class="text-xs text-gray-500">sampai hari ini</span>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Status Meja</h2>
                    <p class="text-sm text-gray-500">Distribusi ketersediaan meja</p>
                </div>
                <span class="text-sm font-semibold text-gray-900">{{ $mejaCount }} meja</span>
            </div>
            <div class="mt-4 h-3 w-full overflow-hidden rounded-full bg-gray-100">
                <div class="h-full" style="background: linear-gradient(90deg, #499587 0%, #5aa897 100%); width: {{ $mejaTersediaPct }}%"></div>
            </div>
            <div class="mt-3 flex items-center justify-between text-sm text-gray-600">
                <span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full" style="background-color: #499587;"></span>{{ $mejaTersedia }} tersedia</span>
                <span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-red-500"></span>{{ $mejaDipakai }} dipakai</span>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Pesanan</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold transition-colors" style="color: #499587;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Lihat semua</a>
            </div>
            <ul class="mt-4 space-y-3 text-sm text-gray-700">
                <li class="flex items-center justify-between rounded-lg border border-gray-100 px-4 py-3 hover:bg-gray-50 transition-colors">
                    <span class="font-medium text-gray-800">Menunggu konfirmasi</span>
                    <span class="rounded-full px-3 py-1 text-xs font-semibold" style="background-color: rgba(73, 149, 135, 0.1); color: #499587;">{{ $orderMenunggu }}</span>
                </li>
                <li class="flex items-center justify-between rounded-lg border border-gray-100 px-4 py-3 hover:bg-gray-50 transition-colors">
                    <span class="font-medium text-gray-800">Total pesanan</span>
                    <span class="rounded-full px-3 py-1 text-xs font-semibold" style="background-color: rgba(73, 149, 135, 0.1); color: #499587;">{{ $orderCount }}</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Laporan Penjualan</h2>
                <p class="text-sm text-gray-500">Akses laporan harian dan bulanan</p>
            </div>
            <a href="{{ route('admin.laporan.index') }}" class="inline-flex items-center rounded-lg px-4 py-2 text-sm font-semibold text-white transition-all duration-200 shadow-lg" style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(73, 149, 135, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1)'">
                Buka Laporan
            </a>
        </div>
        <div class="mt-6 grid gap-4 sm:grid-cols-2">
            <div class="rounded-xl p-4 text-sm border-l-4" style="background-color: rgba(73, 149, 135, 0.05); border-left-color: #499587; color: #3a7a6f;">
                <p class="font-semibold">Laporan Harian</p>
                <p class="mt-1" style="color: #499587;">Pantau performa penjualan per hari.</p>
            </div>
            <div class="rounded-xl p-4 text-sm border-l-4" style="background-color: rgba(73, 149, 135, 0.05); border-left-color: #499587; color: #3a7a6f;">
                <p class="font-semibold">Laporan Bulanan</p>
                <p class="mt-1" style="color: #499587;">Rekap penjualan bulan berjalan.</p>
            </div>
        </div>
    </div>
</div>
@endsection
