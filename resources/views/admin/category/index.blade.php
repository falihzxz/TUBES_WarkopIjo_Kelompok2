@extends('layouts.app')

@section('content')
<!-- Back Button -->
<a href="{{ route('admin.dashboard') }}" class="fixed top-6 left-6 inline-flex items-center gap-x-2 text-lg font-semibold text-blue-600 hover:text-blue-700 transition-colors z-10">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
    Kembali
</a>

<div class="bg-white p-6 rounded shadow w-full max-w-3xl">
    <div class="flex justify-between mb-4">
        <h1 class="text-xl font-bold">Daftar Kategori</h1>
        <a href="/admin/category/create" class="bg-blue-600 text-white px-4 py-2 rounded">
            + Tambah
        </a>
    </div>

    <table class="w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-2">No</th>
                <th class="border p-2">Nama Kategori</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $c)
            <tr>
                <td class="border p-2">{{ $loop->iteration }}</td>
                <td class="border p-2">{{ $c->nama_kategori }}</td>
                <td class="border p-2">
                    <a href="/admin/category/{{ $c->id }}/edit" class="text-blue-600">Edit</a> |
                    <form action="/admin/category/{{ $c->id }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600" data-confirm-action="Hapus kategori?">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
