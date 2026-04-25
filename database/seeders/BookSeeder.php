<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->insert([
            ['title' => 'One Piece Vol. 1', 'description' => 'Awal petualangan Luffy.', 'price' => 45000.00, 'stock' => 100, 'cover_photo' => 'op1.jpg', 'genre_id' => 1, 'author_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Naruto Vol. 1', 'description' => 'Ujian genin Naruto.', 'price' => 40000.00, 'stock' => 80, 'cover_photo' => 'nr1.jpg', 'genre_id' => 1, 'author_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Dragon Ball Vol. 1', 'description' => 'Pertemuan Goku dan Bulma.', 'price' => 50000.00, 'stock' => 50, 'cover_photo' => 'db1.jpg', 'genre_id' => 1, 'author_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Attack on Titan Vol. 1', 'description' => 'Jatuhnya Wall Maria.', 'price' => 55000.00, 'stock' => 120, 'cover_photo' => 'aot1.jpg', 'genre_id' => 1, 'author_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Demon Slayer Vol. 1', 'description' => 'Tragedi keluarga Kamado.', 'price' => 48000.00, 'stock' => 90, 'cover_photo' => 'ds1.jpg', 'genre_id' => 1, 'author_id' => 5, 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
