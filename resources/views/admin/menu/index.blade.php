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
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg" style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m0 0h6M4 12a8 8 0 100-16 8 8 0 000 16z" />
                            </svg>
                        </div>
                        <h1 class="text-4xl font-bold text-gray-900">Manajemen Menu</h1>
                    </div>
                    <p class="text-gray-600 ml-15">Kelola semua menu Warkop Anda dengan mudah</p>
                </div>
                <a href="{{ route('admin.menu.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl" style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Menu Baru
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-8 p-4 bg-green-50 border-l-4 rounded-lg" style="border-left-color: #499587;">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-green-700 font-semibold">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Table Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #f3f4f6 0%, #f9fafb 100%); border-bottom: 2px solid #e5e7eb;">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Menu</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Kategori</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Harga</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Deskripsi</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Foto</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($menus as $menu)
                        <tr class="hover:bg-gray-50 transition-colors {{ !$menu->is_active ? 'opacity-60' : '' }}">
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $menu->nama }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold" style="background-color: rgba(73, 149, 135, 0.1); color: #499587;">
                                    {{ optional($menu->category)->nama ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold" style="color: #499587;">Rp {{ number_format($menu->harga) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($menu->deskripsi, 60) }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($menu->foto)
                                    <img src="{{ asset($menu->foto) }}" alt="{{ $menu->nama }}" class="w-12 h-12 object-cover rounded-lg shadow">
                                @else
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($menu->is_active)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold" style="background-color: rgba(34, 197, 94, 0.1); color: #16a34a;">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold" style="background-color: rgba(220, 38, 38, 0.1); color: #dc2626;">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.menu.edit', $menu->id) }}" class="inline-flex items-center justify-center gap-1 px-3 py-2 text-sm font-semibold rounded-lg transition-all duration-200" style="color: #499587; background-color: rgba(73, 149, 135, 0.1); border: 1px solid rgba(73, 149, 135, 0.2);" onmouseover="this.style.backgroundColor='rgba(73, 149, 135, 0.15)'" onmouseout="this.style.backgroundColor='rgba(73, 149, 135, 0.1)'">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>
                                    @if($menu->is_active)
                                        <form method="POST" action="{{ route('admin.menu.destroy', $menu->id) }}" class="inline" onsubmit="return confirm('Yakin ingin menonaktifkan menu ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center gap-1 px-3 py-2 text-sm font-semibold rounded-lg transition-all duration-200" style="color: #dc2626; background-color: rgba(220, 38, 38, 0.1); border: 1px solid rgba(220, 38, 38, 0.2);" onmouseover="this.style.backgroundColor='rgba(220, 38, 38, 0.15)'" onmouseout="this.style.backgroundColor='rgba(220, 38, 38, 0.1)'">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                </svg>
                                                Nonaktifkan
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.menu.activate', $menu->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center justify-center gap-1 px-3 py-2 text-sm font-semibold rounded-lg transition-all duration-200" style="color: #16a34a; background-color: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.2);" onmouseover="this.style.backgroundColor='rgba(34, 197, 94, 0.15)'" onmouseout="this.style.backgroundColor='rgba(34, 197, 94, 0.1)'">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Aktifkan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4" style="background-color: rgba(73, 149, 135, 0.1);">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" style="color: #499587;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m0 0h6M6 12a6 6 0 100-12 6 6 0 000 12z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Belum Ada Menu</h3>
                                <p class="text-gray-600 mb-6">Mulai dengan membuat menu pertama Anda</p>
                                <a href="{{ route('admin.menu.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 text-white font-semibold rounded-xl transition-all duration-200" style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Buat Menu Sekarang
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Menu</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $menus->count() }}</p>
                    </div>
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg" style="background-color: rgba(73, 149, 135, 0.1);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" style="color: #499587;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m0 0h6M4 12a8 8 0 100-16 8 8 0 000 16z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Kategori</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $menus->groupBy('category_id')->count() }}</p>
                    </div>
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg" style="background-color: rgba(73, 149, 135, 0.1);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" style="color: #499587;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
