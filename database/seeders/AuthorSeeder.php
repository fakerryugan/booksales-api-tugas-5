<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('authors')->insert([
            ['name' => 'Eiichiro Oda', 'photo' => 'oda.jpg', 'bio' => 'Kreator One Piece.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Masashi Kishimoto', 'photo' => 'kishimoto.jpg', 'bio' => 'Kreator Naruto.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Akira Toriyama', 'photo' => 'toriyama.jpg', 'bio' => 'Kreator Dragon Ball.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hajime Isayama', 'photo' => 'isayama.jpg', 'bio' => 'Kreator Attack on Titan.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Koyoharu Gotouge', 'photo' => 'gotouge.jpg', 'bio' => 'Kreator Demon Slayer.', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
