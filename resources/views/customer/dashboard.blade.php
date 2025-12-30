@extends('layouts.app')

@section('content')
<!-- Toast Notification -->
<div id="notificationToast" class="hidden fixed top-4 right-4 bg-white rounded-lg shadow-2xl p-4 max-w-sm z-50 border-l-4 border-custom-green animate-slide-in">
    <div class="flex items-start gap-4">
        <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-custom-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="flex-1">
            <h3 id="toastTitle" class="text-sm font-semibold text-gray-900"></h3>
            <p id="toastMessage" class="text-sm text-gray-600 mt-1"></p>
        </div>
        <button onclick="closeNotificationToast()" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

<style>
@keyframes slideIn {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
.animate-slide-in {
    animation: slideIn 0.3s ease-out;
}
</style>

<!-- Sticky Navigation Bar -->
<header class="sticky top-0 z-50 bg-white shadow-md">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Top Bar -->
        <div class="flex h-16 items-center justify-between">
            <!-- Left: Logo & Search -->
            <div class="flex-1 md:flex md:items-center md:gap-8">
                <!-- Logo -->
                <h1 class="text-2xl md:text-3xl font-black font-bodoni" style="background: linear-gradient(to right, #499587, #5aa897); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">☕ Warkop Ijo</h1>
                
                <!-- Search Input next to logo -->
                <div class="hidden md:flex relative">
                    <input type="text" id="searchInput" placeholder="Cari menu..." class="px-4 py-2 pl-10 bg-gray-100 text-gray-700 rounded-lg border-0 focus:ring-2 focus:ring-custom-green focus:bg-white transition-all w-64" onkeyup="filterMenus()">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Right: Cart, History (conditional) & Logout -->
            <div class="flex items-center gap-4">
                <!-- Cart Button -->
                <a href="{{ route('customer.keranjang') }}" class="relative py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg text-white shadow-md hover:shadow-lg transition-all duration-200 custom-green custom-green-hover">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <div class="flex flex-col items-start hidden sm:flex">
                        <span id="cartCount" class="text-xs leading-none">{{ $cartCount }} Item</span>
                        <span id="cartTotal" class="text-[10px] leading-none opacity-90">Rp {{ number_format($cartTotal) }}</span>
                    </div>
                    @if($cartCount > 0)
                    <span id="cartBadge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">{{ $cartCount }}</span>
                    @endif
                </a>

                @if(!empty($hasOrders) && $hasOrders)
                <!-- Order History Button (only if already ordered) -->
                <a href="{{ route('customer.order-history') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg bg-white text-custom-green border border-custom-green hover:bg-custom-green/5 shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2v-6H3v6a2 2 0 002 2z" />
                    </svg>
                    <span class="hidden sm:inline">Riwayat</span>
                </a>
                @endif

                <!-- Logout Button -->
                <a href="{{ route('logout.customer') }}" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg bg-white text-gray-700 border border-gray-300 hover:bg-red-500 hover:text-white hover:border-red-500 shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span class="hidden sm:inline">Logout</span>
                </a>
            </div>
        </div>

        <!-- Category Links (text-based) -->
        <nav class="border-t border-gray-200 py-4">
            <ul class="flex items-center gap-6 flex-wrap text-sm">
                <li>
                    <a href="{{ route('customer.dashboard') }}" 
                       class="font-semibold transition whitespace-nowrap {{ !$selectedCategory ? 'text-custom-green border-b-2 border-custom-green pb-1' : 'text-gray-700 hover:text-gray-900' }}">
                        Semua Menu
                    </a>
                </li>
                @foreach($categories as $category)
                <li>
                    <a href="{{ route('customer.dashboard', ['category' => $category->id]) }}" 
                       class="font-semibold transition whitespace-nowrap {{ $selectedCategory == $category->id ? 'text-custom-green border-b-2 border-custom-green pb-1' : 'text-gray-700 hover:text-gray-900' }}">
                        {{ $category->nama }}
                    </a>
                </li>
                @endforeach
            </ul>
        </nav>
    </div>
</header>

<!-- Main Content -->
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
    <!-- Welcome Section -->
    <div class="mb-8 p-6 rounded-xl bg-gradient-to-r from-custom-green/5 via-custom-green/10 to-custom-green/5 border border-custom-green/20 shadow-sm">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-3xl md:text-4xl font-black mb-3 leading-tight" style="color: #499587;">Halo, {{ session('customer_name') }}! </h2>
                <p class="text-sm md:text-base font-semibold text-gray-700 flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-custom-green" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    Meja {{ session('meja_id') }}
                </p>
                <p class="text-gray-700 leading-relaxed max-w-2xl">
                    <span class="font-semibold text-gray-700"> Selamat datang!</span> Nikmati kelezatan menu pilihan kami. Dari kopi premium hingga makanan lezat, semuanya disiapkan khusus untuk Anda. 
                    <span class="block mt-2 font-medium text-custom-green">Pesan sekarang dan rasakan pengalaman kuliner terbaik! </span>
                </p>
            </div>
        </div>
    </div>

    @if($menus->count() == 0)
        <div class="bg-white rounded-lg p-8 text-center">
            <p class="text-gray-600 text-lg">Belum ada menu yang tersedia. Silakan tunggu admin menambahkan menu.</p>
        </div>
    @else
        <!-- No Results Message -->
        <div id="noResults" class="hidden bg-white rounded-lg p-8 text-center mb-8">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <p class="text-gray-600 text-lg font-semibold mb-2">Tidak ada menu yang ditemukan</p>
            <p class="text-gray-500">Coba gunakan kata kunci lain</p>
        </div>

        <!-- Listings -->
        <div id="menuGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 mb-8">
            @foreach($menus as $menu)
            <!-- Card -->
            <div class="menu-card group flex flex-col" data-name="{{ strtolower($menu->nama) }}" data-category="{{ strtolower($menu->category->nama ?? '') }}" data-description="{{ strtolower($menu->deskripsi) }}">
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

                        <p class="mt-2 font-bold text-lg text-custom-green">
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
                    <button type="button" onclick="addToCart({{ $menu->id }})" class="py-2 px-3 w-full inline-flex justify-center items-center gap-x-2 text-sm font-medium text-nowrap rounded-xl border border-transparent custom-green text-white custom-green-hover focus:outline-none transition disabled:opacity-50 disabled:pointer-events-none">
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
<div id="successToast" class="hidden fixed bottom-4 right-4 custom-green text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3 z-40 max-w-sm">
    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
    <div class="flex-1">
        <p id="toastMessage" class="font-semibold">Item ditambahkan ke keranjang!</p>
    </div>
    <button onclick="document.getElementById('successToast').classList.add('hidden')" class="text-white hover:text-gray-200">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
    </button>
</div>

<script>
function filterMenus() {
    const searchInput = document.getElementById('searchInput');
    const filter = searchInput.value.toLowerCase();
    const menuCards = document.querySelectorAll('.menu-card');
    const noResults = document.getElementById('noResults');
    const menuGrid = document.getElementById('menuGrid');
    let visibleCount = 0;

    menuCards.forEach(card => {
        const name = card.getAttribute('data-name');
        const category = card.getAttribute('data-category');
        const description = card.getAttribute('data-description');
        
        if (name.includes(filter) || category.includes(filter) || description.includes(filter)) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    // Show/hide no results message
    if (visibleCount === 0) {
        noResults.classList.remove('hidden');
        menuGrid.classList.add('hidden');
    } else {
        noResults.classList.add('hidden');
        menuGrid.classList.remove('hidden');
    }
}

function addToCart(menuId) {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
    
    fetch('{{ route("customer.keranjang.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            menu_id: menuId
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Response dari server:', data);
        if (data.success) {
            showToast(data.message);
            // Update cart display with data from response
            updateCartDisplay(data.cartCount, data.cartTotal);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function updateCartDisplay(count, total) {
    console.log('Update cart display - count:', count, 'total:', total);
    
    // Update cart count text
    const cartCountElement = document.getElementById('cartCount');
    if (cartCountElement) {
        cartCountElement.textContent = count + ' Item';
        console.log('Updated cartCount element');
    }
    
    // Update cart total text
    const cartTotalElement = document.getElementById('cartTotal');
    if (cartTotalElement) {
        const formattedTotal = new Intl.NumberFormat('id-ID').format(total);
        cartTotalElement.textContent = 'Rp ' + formattedTotal;
        console.log('Updated cartTotal element with:', 'Rp ' + formattedTotal);
    }
    
    // Update or add badge
    let badge = document.getElementById('cartBadge');
    
    if (count > 0) {
        if (badge) {
            // Update existing badge
            badge.textContent = count;
            console.log('Updated badge with count:', count);
        } else {
            // Create new badge
            const cartButton = document.querySelector('a[href*="keranjang"]');
            badge = document.createElement('span');
            badge.id = 'cartBadge';
            badge.className = 'absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center';
            badge.textContent = count;
            cartButton.appendChild(badge);
            console.log('Created new badge with count:', count);
        }
    } else if (badge) {
        // Remove badge if count is 0
        badge.remove();
    }
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

// Notifikasi Real-time
let lastNotificationTime = localStorage.getItem('lastNotificationTime') ? parseInt(localStorage.getItem('lastNotificationTime')) : 0;
let isPolling = false;

function pollNotifications() {
    if (isPolling) return;
    isPolling = true;

    fetch('{{ route("customer.notifications.api") }}')
        .then(response => response.json())
        .then(data => {
            if (data.notifications && data.notifications.length > 0) {
                data.notifications.forEach(notification => {
                    const notifTime = new Date(notification.created_at).getTime();
                    if (notifTime > lastNotificationTime) {
                        showNotificationToast(notification.title, notification.message);
                        lastNotificationTime = notifTime;
                        localStorage.setItem('lastNotificationTime', lastNotificationTime);
                    }
                });
            }
        })
        .catch(error => console.log('Notification poll error:', error))
        .finally(() => {
            isPolling = false;
        });
}

function showNotificationToast(title, message) {
    const toast = document.getElementById('notificationToast');
    document.getElementById('toastTitle').textContent = title;
    document.getElementById('toastMessage').textContent = message;
    toast.classList.remove('hidden');
    
    setTimeout(() => {
        toast.classList.add('hidden');
    }, 5000);
}

function closeNotificationToast() {
    document.getElementById('notificationToast').classList.add('hidden');
}

// Poll notifications setiap 5 detik
setInterval(pollNotifications, 5000);
pollNotifications();
</script>

@endsection


