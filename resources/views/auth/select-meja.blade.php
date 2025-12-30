<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pilih Meja - Warkop Tubes</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-white m-0 p-0">
    <!-- Back Button -->
    <a href="/logout-customer" class="fixed top-6 left-6 inline-flex items-center gap-x-2 text-lg font-semibold transition-colors z-10" style="color: #499587;" onmouseover="this.style.color='#3a7a6f'" onmouseout="this.style.color='#499587'">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Logout
    </a>

    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-2xl">
            <div class="bg-white rounded-xl shadow-lg">
                <div class="p-4 sm:p-7">
                    <div class="text-center mb-8">
                        <h1 class="block text-3xl font-bold text-gray-800">Selamat Datang, {{ session('customer_name') }}!</h1>
                        <p class="mt-3 text-base text-gray-600">
                            Pilih nomor meja untuk memulai pemesanan
                        </p>
                    </div>

                    <div class="mt-7">
                        @php
                            $availableCount = $mejas->where('status', 'tersedia')->count();
                        @endphp
                        
                        @if($availableCount == 0)
                            <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-4 mb-6">
                                <p class="text-sm text-yellow-700">Semua meja sedang digunakan. Silakan tunggu meja lain tersedia.</p>
                            </div>
                        @endif

                        <form method="POST" action="/select-meja">
                            @csrf
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-6">
                                @foreach($mejas as $meja)
                                    @php
                                        $isAvailable = $meja->status === 'tersedia' && !in_array($meja->id, $occupiedMejaIds ?? []);
                                    @endphp
                                    <label class="flex flex-col items-center justify-center p-4 border-2 rounded-lg transition {{ $isAvailable ? 'cursor-pointer hover:border-custom-green hover:bg-custom-green/5 border-gray-300' : 'cursor-not-allowed bg-gray-100 border-gray-300 opacity-60' }}">
                                        <input type="radio" name="meja_id" value="{{ $meja->id }}" class="w-4 h-4 {{ $isAvailable ? '' : 'cursor-not-allowed' }}" style="accent-color: #499587;" {{ $isAvailable ? 'required' : 'disabled' }}>
                                        <span class="mt-2 font-semibold {{ $isAvailable ? 'text-gray-900' : 'text-gray-500' }}">Meja {{ $meja->nomor_meja }}</span>
                                        @if(!$isAvailable)
                                            <span class="text-xs text-red-600 font-medium mt-1">Terpakai</span>
                                        @endif
                                    </label>
                                @endforeach
                            </div>

                            <button type="submit" class="w-full py-4 px-4 inline-flex justify-center items-center gap-x-2 text-base font-semibold rounded-lg text-white disabled:opacity-50 disabled:pointer-events-none transition-colors" style="background-color: #499587; outline: none;" onmouseover="this.style.backgroundColor='#3a7a6f'" onmouseout="this.style.backgroundColor='#499587'" onfocus="this.style.backgroundColor='#3a7a6f'" {{ $availableCount == 0 ? 'disabled' : '' }}>
                                {{ $availableCount > 0 ? 'Lanjutkan' : 'Tidak Ada Meja Tersedia' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>
