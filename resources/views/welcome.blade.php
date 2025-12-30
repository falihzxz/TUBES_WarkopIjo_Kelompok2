<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Warkop Ijo - Pilih Login</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-white lg:grid lg:h-screen lg:place-content-center">
    <div class="mx-auto w-screen max-w-7xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8 lg:py-32">
      <div class="mx-auto max-w-prose text-center">
        <h1 class="text-4xl font-bold text-gray-900 sm:text-5xl">
          Selamat Datang di
          <strong style="color: #499587;"> Warkop Ijo </strong>
        </h1>

        <p class="mt-4 text-base text-pretty text-gray-700 sm:text-lg/relaxed">
          Silakan pilih tipe pengguna untuk melanjutkan ke halaman login.
        </p>

        <div class="mt-4 flex justify-center gap-4 sm:mt-6">
          <a class="inline-block rounded px-5 py-3 font-medium text-white shadow-sm transition-colors min-w-[180px] text-center" style="background-color: #499587; border: 1px solid #499587;" onmouseover="this.style.backgroundColor='#3a7a6f'" onmouseout="this.style.backgroundColor='#499587'" href="{{ url('/login-admin') }}">
            Login Admin
          </a>

          <a class="inline-block rounded px-5 py-3 font-medium text-white shadow-sm transition-colors min-w-[180px] text-center" style="background-color: #499587; border: 1px solid #499587;" onmouseover="this.style.backgroundColor='#3a7a6f'" onmouseout="this.style.backgroundColor='#499587'" href="{{ url('/login-customer') }}">
            Login Pelanggan
          </a>
        </div>
      </div>
    </div>
  </body>
</html>
