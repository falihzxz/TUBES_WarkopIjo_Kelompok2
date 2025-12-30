<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - Warkop Tubes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white m-0 p-0">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-xl shadow-lg">
                <div class="p-4 sm:p-7">
                    <div class="text-center mb-8">
                        <h1 class="block text-3xl font-bold text-gray-800">Reset Password</h1>
                        <p class="mt-3 text-base text-gray-600">
                            Masukkan password baru Anda
                        </p>
                    </div>

                    @if($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-6">
                            @foreach($errors->all() as $error)
                                <p class="text-sm text-red-700">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="/reset-password">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">

                        <div class="mb-5">
                            <label for="password" class="block text-sm font-semibold mb-2 text-gray-700">Password Baru</label>
                            <input type="password" id="password" name="password" required autofocus
                                   class="py-3 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-custom-green focus:ring-2 focus:ring-custom-green/20 transition" 
                                   placeholder="Minimal 6 karakter">
                        </div>

                        <div class="mb-5">
                            <label for="password_confirmation" class="block text-sm font-semibold mb-2 text-gray-700">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                   class="py-3 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-custom-green focus:ring-2 focus:ring-custom-green/20 transition" 
                                   placeholder="Ketik ulang password">
                        </div>

                        <button type="submit" class="w-full py-4 px-4 inline-flex justify-center items-center gap-x-2 text-base font-semibold rounded-lg text-white transition-colors" 
                                style="background-color: #499587; outline: none;" 
                                onmouseover="this.style.backgroundColor='#3a7a6f'" 
                                onmouseout="this.style.backgroundColor='#499587'">
                            Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
