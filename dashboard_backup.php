<div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-2">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Selamat Datang, {{ session('customer_name') }}! 👋</h1>
                <p class="text-gray-600 mt-2">Meja {{ session('meja_id') }}</p>
            </div>
            <a href="{{ route('logout.customer') }}" class="text-red-600 hover:text-red-700 font-semibold text-sm flex items-center gap-2 transition-colors hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Logout
            </a>
        </div>
        <div class="mt-4">
            <p class="text-lg text-gray-700 leading-relaxed">
                <span class="font-semibold text-green-600">Nikmati kelezatan menu pilihan kami!</span> 
                Dari kopi premium hingga makanan lezat, semuanya disiapkan khusus untuk Anda. 
                <span class="text-green-700 font-medium">✨ Pesan sekarang dan rasakan pengalaman kuliner terbaik!</span>
            </p>
        </div>
    </div>
@extends('layouts.app')

@section('content')
<!-- Floating Cart Button -->
<div class="fixed top-6 right-6 z-50">
    <a href="{{ route('customer.keranjang') }}" class="relative py-2 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-xl bg-gradient-to-r from-green-500 to-green-600 text-white hover:from-green-600 hover:to-green-700 shadow-lg hover:shadow-xl transition-all duration-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        <div class="flex flex-col items-start">
            <span class="text-xs leading-none">{{ $cartCount }} Item</span>
            <span class="text-[10px] leading-none opacity-90">Rp {{ number_format($cartTotal) }}</span>
        </div>
        @if($cartCount > 0)
        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">{{ $cartCount }}</span>
        @endif
    </a>
</div>

<div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-2">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Selamat Datang, {{ session('customer_name') }}! </h1>
                <p class="text-gray-600 mt-2">Meja {{ session('meja_id') }}</p>
            </div>
            <a href="{{ route('logout.customer') }}" class="text-red-600 hover:text-red-700 font-semibold text-sm flex items-center gap-2 transition-colors hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Logout
            </a>
        </div>
        <div class="mt-4">
            <p class="text-lg text-gray-700 leading-relaxed">
                <span class="font-semibold text-green-600">Nikmati kelezatan menu pilihan kami!</span> 
                Dari kopi premium hingga makanan lezat, semuanya disiapkan khusus untuk Anda. 
                <span class="text-green-700 font-medium"> Pesan sekarang dan rasakan pengalaman kuliner terbaik!</span>
            </p>
        </div>
    </div>

    <!-- Kategori Filter -->
    <div class="mb-8">
        <h2 class="text-xl font-bold mb-4 text-gray-900">Kategori Menu</h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('customer.dashboard') }}" 
               class="px-4 py-2 rounded-lg font-semibold transition-colors
                   {{ !$selectedCategory ? 'bg-green-500 text-white hover:bg-green-600' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Semua Menu
            </a>
            @foreach($categories as $category)
            <a href="{{ route('customer.dashboard', ['category' => $category->id]) }}" 
               class="px-4 py-2 rounded-lg font-semibold transition-colors
                   {{ $selectedCategory == $category->id ? 'bg-green-500 text-white hover:bg-green-600' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                {{ $category->nama }}
            </a>
            @endforeach
        </div>
    </div>

    @if($menus->count() == 0)
        <div class="bg-gray-100 rounded-lg p-8 text-center">
            <p class="text-gray-600 text-lg">Belum ada menu yang tersedia. Silakan tunggu admin menambahkan menu.</p>
        </div>
    @else
        <!-- Listings -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 mb-8">
            @foreach($menus as $menu)
            <!-- Card -->
            <div class="group flex flex-col">
                <div class="relative">
                    <div class="aspect-square overflow-hidden rounded-2xl bg-gray-200">
                        @if($menu->foto)
                            <img class="size-full object-cover rounded-2xl group-hover:scale-105 transition-transform duration-300" src="{{ asset($menu->foto) }}" alt="{{ $menu->nama }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <span>No Photo</span>
                            </div>
                        @endif
                    </div>

                    <div class="pt-4">
                        <h3 class="font-semibold md:text-lg text-gray-900">
                            {{ $menu->nama }}
                        </h3>

                        <p class="mt-2 font-bold text-lg text-green-600">
                            Rp {{ number_format($menu->harga) }}
                        </p>
                    </div>
                </div>

                <div class="mb-2 mt-4 text-sm">
                    <!-- List -->
                    <div class="flex flex-col">
                        <!-- Item: Kategori -->
                        <div class="py-3 border-t border-gray-200">
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <span class="font-medium text-gray-900">Kategori:</span>
                                </div>
                                <div class="text-end">
                                    <span class="text-gray-700">{{ $menu->category->nama ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- End Item -->

                        <!-- Item: Deskripsi -->
                        <div class="py-3 border-t border-gray-200">
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <span class="font-medium text-gray-900">Deskripsi:</span>
                                </div>
                                <div class="text-end">
                                    <span class="text-gray-700 text-xs line-clamp-2">{{ $menu->deskripsi }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- End Item -->
                    </div>
                    <!-- End List -->
                </div>

                <div class="mt-auto">
                    <button type="button" onclick="addToCart({{ $menu->id }})" class="py-2 px-3 w-full inline-flex justify-center items-center gap-x-2 text-sm font-medium text-nowrap rounded-xl border border-transparent bg-green-500 text-white hover:bg-green-600 focus:outline-hidden focus:bg-green-600 transition disabled:opacity-50 disabled:pointer-events-none">
                        Tambah ke Keranjang
                    </button>
                </div>
            </div>
            <!-- End Card -->
            @endforeach
        </div>
        <!-- End Listings -->
    @endif
</div>

<!-- Success Toast -->
<div id="successToast" class="hidden fixed bottom-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3 z-40 max-w-sm">
    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
    <div class="flex-1">
        <p id="toastMessage" class="font-semibold">Item ditambahkan ke keranjang!</p>
    </div>
    <button onclick="document.getElementById('successToast').classList.add('hidden')" class="text-white hover:text-gray-200">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
    </button>
</div>

<script>
function addToCart(menuId) {
    fetch('{{ route("customer.keranjang.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            menu_id: menuId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function showToast(message) {
    const toast = document.getElementById('successToast');
    const toastMessage = document.getElementById('toastMessage');
    toastMessage.textContent = message;
    toast.classList.remove('hidden');
    
    // Auto hide after 3 seconds
    setTimeout(() => {
        toast.classList.add('hidden');
    }, 3000);
}
</script>

@endsection


