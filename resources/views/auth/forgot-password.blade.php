<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password - Warkop Tubes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white m-0 p-0">
    <!-- Back Button -->
    <a href="/login-customer" class="fixed top-6 left-6 inline-flex items-center gap-x-2 text-lg font-semibold transition-colors z-10" style="color: #499587;" onmouseover="this.style.color='#3a7a6f'" onmouseout="this.style.color='#499587'">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali
    </a>

    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-xl shadow-lg">
                <div class="p-4 sm:p-7">
                    <div class="text-center mb-8">
                        <h1 class="block text-3xl font-bold text-gray-800">Lupa Password?</h1>
                        <p class="mt-3 text-base text-gray-600">
                            Masukkan email Anda untuk menerima link reset password
                        </p>
                    </div>

                    @if(session('status'))
                        <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4 mb-6">
                            <p class="text-sm text-green-700">{{ session('status') }}</p>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-6">
                            @foreach($errors->all() as $error)
                                <p class="text-sm text-red-700">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="/forgot-password">
                        @csrf
                        <div class="mb-5">
                            <label for="email" class="block text-sm font-semibold mb-2 text-gray-700">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                   class="py-3 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-custom-green focus:ring-2 focus:ring-custom-green/20 transition" 
                                   placeholder="nama@email.com">
                        </div>

                        <button type="submit" class="w-full py-4 px-4 inline-flex justify-center items-center gap-x-2 text-base font-semibold rounded-lg text-white transition-colors" 
                                style="background-color: #499587; outline: none;" 
                                onmouseover="this.style.backgroundColor='#3a7a6f'" 
                                onmouseout="this.style.backgroundColor='#499587'">
                            Kirim Link Reset Password
                        </button>
                    </form>

                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600">
                            Sudah ingat password? 
                            <a href="/login-customer" class="font-semibold hover:underline" style="color: #499587;">
                                Login di sini
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
