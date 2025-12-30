<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Pelanggan - Warkop Tubes</title>
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
                        <h1 class="block text-3xl font-bold text-gray-800">Daftar Akun</h1>
                        <p class="mt-3 text-base text-gray-600">
                            Buat akun baru untuk mulai memesan
                        </p>
                    </div>

                    <div class="mt-7">
                        @if($errors->any())
                            <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-6 flex items-center gap-3">
                                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    @foreach($errors->all() as $error)
                                        <p class="text-sm text-red-700">{{ $error }}</p>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="/register-customer">
                            @csrf
                            <div class="grid gap-y-4">
                                <!-- Nama -->
                                <div>
                                    <label for="name" class="block text-base font-medium mb-2 text-gray-800">Nama Lengkap</label>
                                    <input type="text" id="name" name="name" class="py-3 px-4 block w-full border border-gray-300 rounded-lg text-base text-gray-800 placeholder-gray-400 disabled:opacity-50 disabled:pointer-events-none bg-white" style="outline: none;" onfocus="this.style.borderColor='#499587'; this.style.boxShadow='0 0 0 2px rgba(73, 149, 135, 0.5)'" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'" placeholder="Masukkan nama lengkap Anda" value="{{ old('name') }}" required>
                                </div>

                                <!-- Username -->
                                <div>
                                    <label for="username" class="block text-base font-medium mb-2 text-gray-800">Username</label>
                                    <input type="text" id="username" name="username" class="py-3 px-4 block w-full border border-gray-300 rounded-lg text-base text-gray-800 placeholder-gray-400 disabled:opacity-50 disabled:pointer-events-none bg-white" style="outline: none;" onfocus="this.style.borderColor='#499587'; this.style.boxShadow='0 0 0 2px rgba(73, 149, 135, 0.5)'" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'" placeholder="Pilih username unik Anda" value="{{ old('username') }}" required>
                                    <p class="text-xs text-gray-500 mt-1">Username hanya boleh huruf, angka, dan underscore</p>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-base font-medium mb-2 text-gray-800">Email</label>
                                    <input type="email" id="email" name="email" class="py-3 px-4 block w-full border border-gray-300 rounded-lg text-base text-gray-800 placeholder-gray-400 disabled:opacity-50 disabled:pointer-events-none bg-white" style="outline: none;" onfocus="this.style.borderColor='#499587'; this.style.boxShadow='0 0 0 2px rgba(73, 149, 135, 0.5)'" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'" placeholder="Masukkan email Anda" value="{{ old('email') }}">
                                </div>

                                <!-- Password -->
                                <div>
                                    <label for="password" class="block text-base font-medium mb-2 text-gray-800">Password</label>
                                    <input type="password" id="password" name="password" class="py-3 px-4 block w-full border border-gray-300 rounded-lg text-base text-gray-800 placeholder-gray-400 disabled:opacity-50 disabled:pointer-events-none bg-white" style="outline: none;" onfocus="this.style.borderColor='#499587'; this.style.boxShadow='0 0 0 2px rgba(73, 149, 135, 0.5)'" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'" placeholder="Masukkan password (minimal 6 karakter)" required>
                                    <p class="text-xs text-gray-500 mt-1">Minimal 6 karakter</p>
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <label for="password_confirmation" class="block text-base font-medium mb-2 text-gray-800">Konfirmasi Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="py-3 px-4 block w-full border border-gray-300 rounded-lg text-base text-gray-800 placeholder-gray-400 disabled:opacity-50 disabled:pointer-events-none bg-white" style="outline: none;" onfocus="this.style.borderColor='#499587'; this.style.boxShadow='0 0 0 2px rgba(73, 149, 135, 0.5)'" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'" placeholder="Ulangi password Anda" required>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-white transition-all" style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                    Daftar Sekarang
                                </button>
                            </div>
                        </form>

                        <!-- Login Link -->
                        <p class="mt-6 text-center text-sm text-gray-600">
                            Sudah punya akun?
                            <a href="/login-customer" class="font-semibold transition-colors" style="color: #499587;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Masuk di sini</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
