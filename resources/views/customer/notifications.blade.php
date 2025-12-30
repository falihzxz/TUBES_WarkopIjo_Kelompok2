@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center gap-2 text-custom-green hover:text-custom-green/80 font-semibold mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <h1 class="text-4xl font-black mb-2" style="color: #499587;">Notifikasi</h1>
            <p class="text-gray-600">Pantau status pesanan Anda di sini</p>
        </div>

        <!-- Notifications List -->
        <div class="space-y-4">
            @forelse($notifications as $notification)
            <div class="bg-white rounded-lg shadow hover:shadow-md transition-shadow p-6 border-l-4 {{ $notification->status === 'unread' ? 'border-custom-green' : 'border-gray-300' }}">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <!-- Badge Status -->
                        <div class="flex items-center gap-3 mb-2">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $notification->status === 'unread' ? 'bg-custom-green/10 text-custom-green' : 'bg-gray-100 text-gray-700' }}">
                                {{ $notification->status === 'unread' ? 'Baru' : 'Dibaca' }}
                            </span>
                            <span class="text-xs text-gray-500">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $notification->title }}</h3>

                        <!-- Message -->
                        <p class="text-gray-700 mb-3">{{ $notification->message }}</p>

                        <!-- Order Info (jika ada) -->
                        @if($notification->order)
                        <div class="bg-gray-50 rounded p-3 mb-3">
                            <p class="text-sm text-gray-600"><strong>Order #{{ $notification->order->id }}</strong></p>
                            <p class="text-sm text-gray-600">Total: <strong>Rp {{ number_format($notification->order->total_harga) }}</strong></p>
                            <p class="text-sm text-gray-600">Status: <strong>{{ ucfirst($notification->order->status) }}</strong></p>
                        </div>
                        @endif
                    </div>

                    <!-- Action Button -->
                    @if($notification->status === 'unread')
                    <button onclick="markAsRead({{ $notification->id }})" class="flex-shrink-0 py-2 px-4 rounded-lg bg-custom-green text-white hover:bg-custom-green/90 font-semibold text-sm transition-colors">
                        Tandai Dibaca
                    </button>
                    @endif
                </div>
            </div>
            @empty
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak ada notifikasi</h3>
                <p class="text-gray-600">Notifikasi akan muncul di sini ketika pesanan Anda diperbarui</p>
            </div>
            @endforelse
        </div>

        <!-- Unread Count -->
        @php
            $unreadCount = $notifications->where('status', 'unread')->count();
        @endphp
        @if($unreadCount > 0)
        <div class="mt-8 p-4 bg-custom-green/10 border border-custom-green/30 rounded-lg text-center">
            <p class="text-custom-green font-semibold">Anda memiliki {{ $unreadCount }} notifikasi yang belum dibaca</p>
        </div>
        @endif
    </div>
</div>

<script>
function markAsRead(notificationId) {
    fetch(`/customer/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endsection
