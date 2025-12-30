@extends('layouts.app')

@section('content')
<!-- Main Content -->
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
    <!-- Page Title -->
    <div class="mb-10 pt-4">
        <h1 class="text-4xl font-black leading-snug mb-4 pb-1" style="background: linear-gradient(to right, #499587, #5aa897); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Keranjang Belanja</h1>
        <p class="text-gray-600">Periksa dan selesaikan pembelian Anda</p>
    </div>

    @if($message = Session::get('success'))
        <div class="bg-green-50 border-l-4 border-custom-green rounded-lg p-4 mb-6 flex items-center gap-3">
            <svg class="w-6 h-6 text-custom-green flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <p class="text-custom-green font-semibold">{{ $message }}</p>
        </div>
    @endif

    @if($message = Session::get('error'))
        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-6 flex items-center gap-3">
            <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            <p class="text-red-700 font-semibold">{{ $message }}</p>
        </div>
    @endif

    @if($keranjang->count() == 0)
        <!-- Empty Cart -->
        <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-gray-200">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Keranjang Kosong</h3>
            <p class="text-gray-600 mb-6">Belum ada menu yang ditambahkan ke keranjang</p>
            <a href="{{ route('customer.dashboard') }}" class="inline-block custom-green text-white px-8 py-3 rounded-lg font-semibold custom-green-hover transition">
                Kembali Belanja
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Items List -->
            <div class="lg:col-span-2">
                <div class="space-y-4">
                    @foreach($keranjang as $item)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                        <div class="flex gap-4">
                            <!-- Checkbox -->
                            <div class="flex-shrink-0 flex items-start pt-1">
                                <input type="checkbox" class="item-checkbox w-5 h-5 text-custom-green cursor-pointer" data-item-id="{{ $item->id }}" value="{{ $item->id }}">
                            </div>

                            <!-- Menu Image -->
                            <div class="flex-shrink-0 w-24 h-24">
                                @if($item->menu->foto)
                                    <img src="{{ asset($item->menu->foto) }}" alt="{{ $item->menu->nama }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <div class="w-full h-full bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                                        <span class="text-xs text-center">No Photo</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Item Details -->
                            <div class="flex-1 min-w-0">
                                <div class="mb-2">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $item->menu->nama }}</h3>
                                    <p class="text-sm text-gray-600">{{ $item->menu->category->nama ?? '-' }}</p>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="text-xl font-bold text-custom-green">
                                        Rp {{ number_format($item->menu->harga) }}
                                    </div>

                                    <!-- Quantity Controls -->
                                    <form action="{{ route('customer.cart.update-qty', $item->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="qty" id="qty_{{ $item->id }}" value="{{ $item->qty }}">
                                        
                                        <button type="button" onclick="decreaseQty({{ $item->id }})" class="p-2 border border-gray-300 rounded-lg hover:border-custom-green hover:text-custom-green transition">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/></svg>
                                        </button>
                                        
                                        <span id="qty_display_{{ $item->id }}" class="w-8 text-center font-bold text-gray-900">{{ $item->qty }}</span>
                                        
                                        <button type="button" onclick="increaseQty({{ $item->id }})" class="p-2 border border-gray-300 rounded-lg hover:border-custom-green hover:text-custom-green transition">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                                        </button>

                                        <button type="submit" class="ml-2 px-3 py-2 text-xs font-semibold text-white custom-green rounded-lg custom-green-hover transition hidden">
                                            Update
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Subtotal -->
                            <div class="flex-shrink-0 text-right">
                                <p class="text-sm text-gray-600 mb-1">Subtotal</p>
                                <p class="text-xl font-bold text-custom-green" id="subtotal_display_{{ $item->id }}">
                                    Rp {{ number_format($item->menu->harga * $item->qty) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Summary & Checkout -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-32">
                    <!-- Total Card -->
                    <div class="bg-gradient-to-br from-custom-green/10 to-custom-green/5 rounded-xl p-4 mb-6 border border-custom-green/20">
                        <p class="text-sm text-gray-600 mb-1">Total Belanja</p>
                        <h2 class="text-3xl font-black text-custom-green" id="totalAmountDisplay">
                            Rp {{ number_format($keranjang->sum(fn($item) => $item->menu->harga * $item->qty)) }}
                        </h2>
                        <p class="text-xs text-gray-600 mt-2"><span id="totalItemCountDisplay">{{ $keranjang->sum('qty') }}</span> item</p>
                    </div>

                    <!-- Delete Selected Button -->
                    <button type="button" id="deleteSelectedBtn" disabled class="w-full px-4 py-2 bg-red-50 text-red-600 border-2 border-red-200 rounded-lg font-semibold hover:bg-red-100 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 mb-6">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus Terpilih
                    </button>

                    <hr class="mb-6 border-gray-200">

                    <!-- Checkout Form -->
                    <form action="{{ route('customer.checkout') }}" method="POST">
                        @csrf
                        
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-900 mb-3">Catatan Khusus</label>
                            <textarea name="catatan_umum" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-custom-green/50 focus:border-custom-green resize-none" rows="3" placeholder="Misal: Tidak pakai gula..."></textarea>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-900 mb-3">Metode Pembayaran</label>
                            <div class="space-y-2">
                                <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-custom-green hover:bg-custom-green/5 transition">
                                    <input type="radio" name="metode_pembayaran" value="tunai" class="w-5 h-5 text-custom-green" required>
                                    <div class="ml-3 flex-1">
                                        <p class="font-semibold text-gray-900 text-sm">Tunai</p>
                                        <p class="text-xs text-gray-600">Bayar langsung ke kasir</p>
                                    </div>
                                </label>
                                <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-custom-green hover:bg-custom-green/5 transition">
                                    <input id="pay-qris" type="radio" name="metode_pembayaran" value="qris" class="w-5 h-5 text-custom-green" required>
                                    <div class="ml-3 flex-1">
                                        <p class="font-semibold text-gray-900 text-sm">QRIS</p>
                                        <p class="text-xs text-gray-600">Scan QR untuk pembayaran</p>
                                    </div>
                                </label>
                                
                                <!-- QRIS Panel -->
                                <div id="qrisPanel" class="hidden mt-3">
                                    <div class="rounded-xl border border-custom-green/30 bg-custom-green/5 p-6">
                                        <div class="flex items-center justify-between mb-4">
                                            <p class="text-sm font-semibold text-gray-900">QRIS Pembayaran</p>
                                            <span class="text-xs px-2 py-1 rounded bg-white border border-custom-green/40 text-custom-green">Auto-verifikasi</span>
                                        </div>
                                        
                                        <!-- QR Code Center -->
                                        <div class="flex justify-center mb-6">
                                            <div class="rounded-lg bg-white border border-gray-200 p-3 shadow-md">
                                                <img src="/images/qris.jpeg" alt="QRIS" class="w-56 h-56 object-contain">
                                            </div>
                                        </div>

                                        <!-- Amount and Instructions Below -->
                                        <div class="text-center">
                                            <p class="text-sm text-gray-600 mb-2">Jumlah yang harus dibayar</p>
                                            <p class="text-3xl font-black text-custom-green mb-4" id="qrisTotalDisplay">Rp {{ number_format($keranjang->sum(fn($item) => $item->menu->harga * $item->qty)) }}</p>
                                            <div class="bg-white rounded-lg p-4 text-left">
                                                <p class="text-sm font-semibold text-gray-900 mb-2">Petunjuk Pembayaran:</p>
                                                <ul class="text-sm text-gray-600 space-y-2">
                                                    <li class="flex items-start gap-2">
                                                        <span class="text-custom-green font-bold">1.</span>
                                                        <span>Buka aplikasi e-wallet/mobile banking Anda</span>
                                                    </li>
                                                    <li class="flex items-start gap-2">
                                                        <span class="text-custom-green font-bold">2.</span>
                                                        <span>Scan kode QR di atas</span>
                                                    </li>
                                                    <li class="flex items-start gap-2">
                                                        <span class="text-custom-green font-bold">3.</span>
                                                        <span>Pastikan nominal sesuai dengan total belanja</span>
                                                    </li>
                                                    <li class="flex items-start gap-2">
                                                        <span class="text-custom-green font-bold">4.</span>
                                                        <span>Konfirmasi pembayaran dan tunggu status lunas</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full custom-green text-white font-semibold py-3 rounded-lg custom-green-hover transition flex items-center justify-center gap-2 mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Checkout
                        </button>
                        
                        <a href="{{ route('customer.dashboard') }}" class="block w-full text-center border-2 border-gray-300 text-gray-700 font-semibold py-3 rounded-lg hover:border-gray-400 transition mb-3">
                            Lanjut Belanja
                        </a>

                        
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function increaseQty(itemId) {
    const qtyInput = document.getElementById('qty_' + itemId);
    const qtyDisplay = document.getElementById('qty_display_' + itemId);
    let currentQty = parseInt(qtyInput.value);
    currentQty++;
    qtyInput.value = currentQty;
    qtyDisplay.textContent = currentQty;
    updateQtyAjax(itemId, currentQty);
}

function decreaseQty(itemId) {
    const qtyInput = document.getElementById('qty_' + itemId);
    const qtyDisplay = document.getElementById('qty_display_' + itemId);
    let currentQty = parseInt(qtyInput.value);
    if (currentQty > 1) {
        currentQty--;
        qtyInput.value = currentQty;
        qtyDisplay.textContent = currentQty;
        updateQtyAjax(itemId, currentQty);
    }
}

function formatRupiah(num) {
    try {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(num);
    } catch (e) {
        return 'Rp ' + num;
    }
}

function updateQtyAjax(itemId, qty) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch('/customer/keranjang/' + itemId, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ qty })
    })
    .then(async res => {
        const data = await res.json().catch(() => null);
        if (!res.ok || !data || data.success === false) throw new Error(data?.message || 'Gagal memperbarui');
        // Update item subtotal
        const subtotalEl = document.getElementById('subtotal_display_' + itemId);
        if (subtotalEl) subtotalEl.textContent = formatRupiah(data.itemSubtotal);
        // Update totals
        const totalEl = document.getElementById('totalAmountDisplay');
        const countEl = document.getElementById('totalItemCountDisplay');
        const qrisEl = document.getElementById('qrisTotalDisplay');
        if (totalEl) totalEl.textContent = formatRupiah(data.cartTotal);
        if (countEl) countEl.textContent = data.cartCount;
        if (qrisEl) qrisEl.textContent = formatRupiah(data.cartTotal);
        // Optionally update global cart header if present
        const cartCountEl = document.getElementById('cartCount');
        const cartTotalEl = document.getElementById('cartTotal');
        const cartBadgeEl = document.getElementById('cartBadge');
        if (cartCountEl) cartCountEl.textContent = data.cartCount;
        if (cartTotalEl) cartTotalEl.textContent = formatRupiah(data.cartTotal);
        if (cartBadgeEl) cartBadgeEl.textContent = data.cartCount;
    })
    .catch(err => {
        console.error('Update qty failed:', err);
        // Minimal feedback; could add toast UI
        alert('Gagal memperbarui jumlah. Coba lagi.');
    });
}

// Handle delete selected items
document.getElementById('deleteSelectedBtn').addEventListener('click', function() {
    const checkboxes = document.querySelectorAll('.item-checkbox:checked');
    if (checkboxes.length === 0) return;
    
    if (confirm('Hapus ' + checkboxes.length + ' item terpilih?')) {
        checkboxes.forEach(checkbox => {
            const itemId = checkbox.dataset.itemId;
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/customer/keranjang/' + itemId;
            form.innerHTML = '@csrf @method("DELETE")';
            document.body.appendChild(form);
            form.submit();
        });
    }
});

// Handle checkbox changes
document.querySelectorAll('.item-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const hasChecked = document.querySelectorAll('.item-checkbox:checked').length > 0;
        document.getElementById('deleteSelectedBtn').disabled = !hasChecked;
    });
});
</script>

<script>
// Toggle QRIS panel visibility when payment method changes
document.addEventListener('DOMContentLoaded', function() {
    const qrisRadio = document.querySelector('input[name="metode_pembayaran"][value="qris"]');
    const cashRadio = document.querySelector('input[name="metode_pembayaran"][value="tunai"]');
    const qrisPanel = document.getElementById('qrisPanel');

    function updatePanel() {
        if (qrisRadio && qrisRadio.checked) {
            qrisPanel.classList.remove('hidden');
        } else {
            qrisPanel.classList.add('hidden');
        }
    }

    if (qrisRadio) {
        qrisRadio.addEventListener('change', updatePanel);
    }
    if (cashRadio) {
        cashRadio.addEventListener('change', updatePanel);
    }

    // Initialize on load in case of back navigation
    updatePanel();
});
</script>
