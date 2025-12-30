<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Hapus kategori yang tidak diperlukan
        Category::whereNotIn('nama', ['Makanan', 'Minuman', 'Snack'])->delete();
        
        // Tambahkan kategori baru jika belum ada
        Category::firstOrCreate(['nama' => 'Makanan']);
        Category::firstOrCreate(['nama' => 'Minuman']);
        Category::firstOrCreate(['nama' => 'Snack']);
    }
}
