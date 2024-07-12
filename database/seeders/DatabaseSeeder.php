<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Tạo 1 bảng ghi
        // DB::table('users')->insert(
        //     [
        //         'name' => 'AdminTaoPro',
        //         'email' => 'caotancong2003@gmail.com',
        //         'password' => Hash::make('password'),
        //     ]
        // );

        //Tạo nhiều bảng ghi
        $this->call([
            UserSeeder::class
        ]);
    }
}
