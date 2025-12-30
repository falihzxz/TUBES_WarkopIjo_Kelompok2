@extends('layouts.app')

@section('content')
<!-- Card Section -->
<div class="max-w-4xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
  <!-- Card -->
  <div class="bg-white rounded-xl shadow-xs p-4 sm:p-7">
    <!-- Validation Errors -->
    @if($errors->any())
      <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
        <div class="flex items-center gap-3 mb-3">
          <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
          </svg>
          <h3 class="text-red-800 font-semibold">Terjadi Kesalahan!</h3>
        </div>
        <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    
    <form method="POST" action="{{ route('admin.menu.store') }}" enctype="multipart/form-data">
      @csrf
      
      <!-- Section: Menu Details -->
      <div class="grid sm:grid-cols-12 gap-2 sm:gap-4 py-8 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200 first:border-transparent">
        <div class="sm:col-span-12 text-center">
          <h2 class="text-lg font-semibold text-gray-800">
            Informasi Menu
          </h2>
        </div>
        <!-- End Col -->

        <div class="sm:col-span-3">
          <label for="nama" class="inline-block text-sm font-medium text-gray-500 mt-2.5">
            Nama Menu
          </label>
        </div>
        <!-- End Col -->

        <div class="sm:col-span-9">
          <input id="nama" type="text" name="nama" value="{{ old('nama') }}" class="py-1.5 sm:py-2 px-3 pe-11 block w-full border border-gray-300 shadow-sm rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none {{ $errors->has('nama') ? 'border-red-500' : '' }}" placeholder="Nama menu" required>
          @if($errors->has('nama'))
            <p class="mt-1 text-sm text-red-600">{{ $errors->first('nama') }}</p>
          @endif
        </div>
        <!-- End Col -->

        <div class="sm:col-span-3">
          <label for="category_id" class="inline-block text-sm font-medium text-gray-500 mt-2.5">
            Kategori
          </label>
        </div>
        <!-- End Col -->

        <div class="sm:col-span-9">
          <select id="category_id" name="category_id" class="py-1.5 sm:py-2 px-3 pe-11 block w-full border border-gray-300 shadow-sm rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none {{ $errors->has('category_id') ? 'border-red-500' : '' }}" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->nama }}</option>
            @endforeach
          </select>
          @if($errors->has('category_id'))
            <p class="mt-1 text-sm text-red-600">{{ $errors->first('category_id') }}</p>
          @endif
        </div>
        <!-- End Col -->

        <div class="sm:col-span-3">
          <label for="harga" class="inline-block text-sm font-medium text-gray-500 mt-2.5">
            Harga
          </label>
        </div>
        <!-- End Col -->

        <div class="sm:col-span-9">
          <input id="harga" type="text" name="harga" value="{{ old('harga') }}" class="py-1.5 sm:py-2 px-3 pe-11 block w-full border border-gray-300 shadow-sm rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none {{ $errors->has('harga') ? 'border-red-500' : '' }}" placeholder="0" required>
          @if($errors->has('harga'))
            <p class="mt-1 text-sm text-red-600">{{ $errors->first('harga') }}</p>
          @endif
        </div>
        <!-- End Col -->

        <div class="sm:col-span-3">
          <label for="deskripsi" class="inline-block text-sm font-medium text-gray-500 mt-2.5">
            Deskripsi
          </label>
        </div>
        <!-- End Col -->

        <div class="sm:col-span-9">
          <textarea id="deskripsi" name="deskripsi" class="py-1.5 sm:py-2 px-3 block w-full border border-gray-300 shadow-sm rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none {{ $errors->has('deskripsi') ? 'border-red-500' : '' }}" rows="4" placeholder="Deskripsi menu..." required>{{ old('deskripsi') }}</textarea>
          @if($errors->has('deskripsi'))
            <p class="mt-1 text-sm text-red-600">{{ $errors->first('deskripsi') }}</p>
          @endif
        </div>
        <!-- End Col -->
      </div>
      <!-- End Section -->

      <!-- Section: Photo -->
      <div class="grid sm:grid-cols-12 gap-2 sm:gap-4 py-8 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200 first:border-transparent">
        <div class="sm:col-span-12">
          <h2 class="text-lg font-semibold text-gray-800">
            Foto Menu
          </h2>
        </div>
        <!-- End Col -->

        <div class="sm:col-span-3">
          <label for="foto" class="inline-block text-sm font-medium text-gray-500 mt-2.5">
            Upload Foto
          </label>
        </div>
        <!-- End Col -->

        <div class="sm:col-span-9">
          <input type="file" name="foto" id="foto" class="block w-full border border-gray-300 shadow-sm rounded-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none file:bg-gray-50 file:border-0 file:bg-gray-100 file:me-4 file:py-2 file:px-4">
          @if($errors->has('foto'))
            <p class="mt-1 text-sm text-red-600">{{ $errors->first('foto') }}</p>
          @endif
        </div>
        <!-- End Col -->

        <div class="sm:col-span-3"></div>
        <div class="sm:col-span-9">
          <div id="photoPreview" class="mt-6 hidden">
            <img id="previewImage" src="" alt="Preview" class="max-w-sm rounded-lg shadow-lg">
          </div>
        </div>
        <!-- End Col -->
      </div>
      <!-- End Section -->

      <!-- Section: Submit -->
      <div class="py-8 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200 first:border-transparent">
        <div class="flex gap-3">
          <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-white transition-all duration-200" style="background: linear-gradient(135deg, #499587 0%, #5aa897 100%);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(73, 149, 135, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            Simpan Menu
          </button>
          <a href="{{ route('admin.menu.index') }}" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">
            Batal
          </a>
        </div>
      </div>
      <!-- End Section -->
    </form>
  </div>
  <!-- End Card -->
</div>
<!-- End Card Section -->

<script>
  document.getElementById('foto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(event) {
        const preview = document.getElementById('previewImage');
        preview.src = event.target.result;
        document.getElementById('photoPreview').classList.remove('hidden');
      };
      reader.readAsDataURL(file);
    }
  });
</script>
@endsection
