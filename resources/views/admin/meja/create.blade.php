@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-lg">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header with gradient -->
            <div class="px-8 py-6 text-center" style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white bg-opacity-20 rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Tambah Meja Baru</h1>
                <p class="text-white text-opacity-90 mt-2">Isi form di bawah untuk menambahkan meja</p>
            </div>

            <!-- Form -->
            <div class="px-8 py-8">
                <form method="POST" action="{{ route('admin.meja.store') }}">
                    @csrf

                    <div class="mb-6">
                        <label for="nomor_meja" class="block text-sm font-semibold text-gray-700 mb-3">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" style="color: #499587;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                </svg>
                                Nomor Meja
                            </div>
                        </label>
                        <div class="relative">
                            <input 
                                type="text" 
                                id="nomor_meja"
                                name="nomor_meja" 
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 transition-all duration-200 focus:outline-none" 
                                style="outline: none;" 
                                onfocus="this.style.borderColor='#499587'; this.style.boxShadow='0 0 0 3px rgba(73, 149, 135, 0.1)'" 
                                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'"
                                placeholder="Contoh: Meja 1 atau A1" 
                                required>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Masukkan nomor atau kode meja yang unik</p>
                    </div>

                    <div class="flex gap-3 mt-8">
                        <a href="{{ route('admin.meja.index') }}" class="flex-1 px-4 py-3 text-center border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                            Batal
                        </a>
                        <button 
                            type="submit" 
                            class="flex-1 px-4 py-3 text-white font-semibold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg"
                            style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);"
                            onmouseover="this.style.transform='translateY(-2px)'"
                            onmouseout="this.style.transform='translateY(0)'">
                            <span class="flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Meja
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Card -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm text-blue-800">
                    <p class="font-semibold mb-1">Tips:</p>
                    <p>Gunakan nama meja yang mudah diingat dan konsisten dengan tata letak restoran Anda.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
