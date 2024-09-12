<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Level;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Level::insert(
            [
                'id_level' => '1',
                'namalevel' => 'Admin',
            ],
            [
                'id_level' => '2',
                'namalevel' => 'Pembina',
            ],
            [
                'id_level' => '3',
                'namalevel' => 'Orang Tua',
            ],
            [
                'id_level' => '4',
                'namalevel' => 'Siswa',
            ],
        );

        User::create([
            'name' => 'Admin',
            'username' => 'Admin',
            'level_id' => '1',
            'password' => bcrypt('12345678'),
            'telp' => '6282268156057'
        ]);
    }
}
