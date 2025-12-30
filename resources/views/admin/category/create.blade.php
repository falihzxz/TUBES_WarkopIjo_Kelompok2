@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white p-6 rounded shadow w-full">
        <h1 class="text-xl font-bold mb-4 text-center">Tambah Kategori</h1>

    <form method="POST" action="/admin/category">
        @csrf
        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text" name="nama_kategori" class="w-full border p-2 rounded">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Simpan
        </button>
    </form>
    </div>
</div>
@endsection
