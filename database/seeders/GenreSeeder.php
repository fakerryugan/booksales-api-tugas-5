<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('genres')->insert([
            ['name' => 'Shonen', 'description' => 'Aksi dan petualangan untuk remaja pria.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Shojo', 'description' => 'Fokus pada romansa untuk remaja wanita.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Seinen', 'description' => 'Cerita kompleks untuk pria dewasa.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Isekai', 'description' => 'Karakter utama berpindah ke dunia lain.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Slice of Life', 'description' => 'Potongan kehidupan sehari-hari.', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
