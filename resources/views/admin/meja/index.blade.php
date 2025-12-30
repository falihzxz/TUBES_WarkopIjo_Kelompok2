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
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h1 class="text-4xl font-bold text-gray-900">Manajemen Meja</h1>
                    </div>
                    <p class="text-gray-600 ml-15">Kelola semua meja Warkop Anda dengan mudah</p>
                </div>
                <a href="{{ route('admin.meja.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl" style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Meja Baru
                </a>
            </div>
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
        @if(count($mejas) == 0)
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full mb-4" style="background-color: rgba(73, 149, 135, 0.1);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" style="color: #499587;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m0 0h6M6 12a6 6 0 100-12 6 6 0 000 12z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Meja</h3>
                <p class="text-gray-600 mb-6">Mulai dengan membuat meja pertama Anda untuk melayani pelanggan</p>
                <a href="{{ route('admin.meja.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 text-white font-semibold rounded-xl transition-all duration-200" style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Meja Sekarang
                </a>
            </div>
        @else
            <!-- Meja Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($mejas as $meja)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <!-- Card Header with Status -->
                        <div class="relative p-6 pb-4" style="border-bottom: 2px solid {{ $meja->status === 'tersedia' ? '#d1fae5' : '#fee2e2' }};">
                            <div class="flex flex-wrap items-start justify-between gap-4 mb-4">
                                <h3 class="text-2xl font-bold text-gray-900">{{ $meja->nomor_meja }}</h3>
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold md:shrink-0" style="background-color: {{ $meja->status === 'tersedia' ? 'rgba(73, 149, 135, 0.1)' : 'rgba(239, 68, 68, 0.1)' }}; color: {{ $meja->status === 'tersedia' ? '#059669' : '#dc2626' }};">
                                    @if($meja->status === 'tersedia')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        Tersedia
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                        Tidak Tersedia
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full" style="background-color: {{ $meja->status === 'tersedia' ? '#10b981' : '#ef4444' }};"></div>
                                <span class="text-sm text-gray-600 font-medium">{{ $meja->status === 'tersedia' ? 'Siap Digunakan' : 'Sedang Digunakan' }}</span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="px-6 py-4">
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" style="color: #499587;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    ID Meja: <span class="font-semibold text-gray-900 ml-1">#{{ $meja->id }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer with Actions -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-wrap gap-3 sm:gap-4">
                            <a href="{{ route('admin.meja.edit', $meja->id) }}" class="flex-1 basis-[160px] inline-flex items-center justify-center gap-2 px-3 py-2 text-sm font-semibold rounded-lg transition-all duration-200" style="color: #499587; background-color: rgba(73, 149, 135, 0.1); border: 1px solid rgba(73, 149, 135, 0.2);" onmouseover="this.style.backgroundColor='rgba(73, 149, 135, 0.15)'" onmouseout="this.style.backgroundColor='rgba(73, 149, 135, 0.1)'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </a>

                            @if($meja->status !== 'tersedia')
                            <form action="{{ route('admin.meja.release', $meja->id) }}" method="POST" class="flex-1 basis-[160px]">
                                @csrf
                                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 text-sm font-semibold rounded-lg transition-all duration-200" style="color: #059669; background-color: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.2);" onmouseover="this.style.backgroundColor='rgba(16, 185, 129, 0.18)'" onmouseout="this.style.backgroundColor='rgba(16, 185, 129, 0.12)'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Tandai Tersedia
                                </button>
                            </form>
                            @endif

                            <form action="{{ route('admin.meja.destroy', $meja->id) }}" method="POST" class="flex-1 basis-[160px]" onsubmit="return confirm('Yakin ingin menghapus meja ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 text-sm font-semibold rounded-lg transition-all duration-200" style="color: #dc2626; background-color: rgba(220, 38, 38, 0.1); border: 1px solid rgba(220, 38, 38, 0.2);" onmouseover="this.style.backgroundColor='rgba(220, 38, 38, 0.15)'" onmouseout="this.style.backgroundColor='rgba(220, 38, 38, 0.1)'">
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

            <!-- Summary Stats -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Meja</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $mejas->count() }}</p>
                        </div>
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg" style="background-color: rgba(73, 149, 135, 0.1);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" style="color: #499587;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Meja Tersedia</p>
                            <p class="text-3xl font-bold text-green-600 mt-2">{{ $mejas->where('status', 'tersedia')->count() }}</p>
                        </div>
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg" style="background-color: rgba(16, 185, 129, 0.1);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Meja Digunakan</p>
                            <p class="text-3xl font-bold text-red-600 mt-2">{{ $mejas->where('status', '!=', 'tersedia')->count() }}</p>
                        </div>
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg" style="background-color: rgba(239, 68, 68, 0.1);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
