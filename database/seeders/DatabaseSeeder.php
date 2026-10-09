<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Eksekusi 5 Kategori
        $this->call([KategoriSeeder::class]);
        
        // 2. Generate 20 Buku acak
        Buku::factory(20)->create();
    }
}