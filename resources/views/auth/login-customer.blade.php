<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Pelanggan - Warkop Tubes</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-white m-0 p-0">
    <!-- Back Button -->
    <a href="{{ url('/') }}" class="fixed top-6 left-6 inline-flex items-center gap-x-2 text-lg font-semibold transition-colors z-10" style="color: #499587;" onmouseover="this.style.color='#3a7a6f'" onmouseout="this.style.color='#499587'">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali
    </a>

    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-xl shadow-lg">
                <div class="p-4 sm:p-7">
                    <div class="text-center">
                        <h1 class="block text-3xl font-bold text-gray-800">Login Pelanggan</h1>
                        <p class="mt-3 text-base text-gray-600">
                            Masukkan username dan password Anda
                        </p>
                    </div>

                    <div class="mt-7">
                        @if(session('status'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($errors->any())
                            <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-6">
                                @foreach($errors->all() as $error)
                                    <p class="text-sm text-red-700">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <!-- Form -->
                        <form method="POST" action="/login-customer">
                            @csrf
                            <div class="grid gap-y-4">
                                <!-- Username -->
                                <div>
                                    <label for="username" class="block text-base font-medium mb-2 text-gray-800">Username</label>
                                    <input type="text" id="username" name="username" class="py-3 px-4 block w-full border border-gray-300 rounded-lg text-base text-gray-800 placeholder-gray-400 disabled:opacity-50 disabled:pointer-events-none bg-white" style="outline: none;" onfocus="this.style.borderColor='#499587'; this.style.boxShadow='0 0 0 2px rgba(73, 149, 135, 0.5)'" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'" placeholder="Masukkan username Anda" value="{{ old('username') }}" required>
                                </div>

                                <!-- Password -->
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <label for="password" class="block text-base font-medium text-gray-800">Password</label>
                                        <a href="/forgot-password" class="text-sm font-semibold transition-colors" style="color: #499587;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Lupa Password?</a>
                                    </div>
                                    <input type="password" id="password" name="password" class="py-3 px-4 block w-full border border-gray-300 rounded-lg text-base text-gray-800 placeholder-gray-400 disabled:opacity-50 disabled:pointer-events-none bg-white" style="outline: none;" onfocus="this.style.borderColor='#499587'; this.style.boxShadow='0 0 0 2px rgba(73, 149, 135, 0.5)'" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'" placeholder="Masukkan password Anda" required>
                                </div>

                                <button type="submit" class="w-full py-4 px-4 inline-flex justify-center items-center gap-x-2 text-base font-semibold rounded-lg text-white disabled:opacity-50 disabled:pointer-events-none transition-colors" style="background-color: #499587; outline: none;" onmouseover="this.style.backgroundColor='#3a7a6f'" onmouseout="this.style.backgroundColor='#499587'" onfocus="this.style.backgroundColor='#3a7a6f'">
                                    Masuk
                                </button>
                            </div>
                        </form>
                        <!-- End Form -->

                        <!-- Register Link -->
                        <p class="mt-6 text-center text-sm text-gray-600">
                            Belum punya akun?
                            <a href="/register-customer" class="font-semibold transition-colors" style="color: #499587;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Daftar di sini</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>
