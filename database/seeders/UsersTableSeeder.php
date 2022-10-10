<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin Admin',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'created_at' => now(),
            'updated_at' => now(),
            'role_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'Iglesia las Alamedas',
            'username' => 'alamedas',
            'email' => 'las_alamedas@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'phone' => "8261294673",
            'state' => "Jalisco",
            'municipality' => "Guadalajara",
            'address' => "Calle 1 # 2 Col. 3",
            'created_at' => now(),
            'updated_at' => now(),
            'role_id' => 2,
        ]);

        DB::table('users')->insert([
            'name' => 'Iglesia Zambrano',
            'username' => 'zambrano',
            'email' => 'zambrano@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'phone' => "1234567890",
            'state' => "Sonora",
            'municipality' => "Hermosillo",
            'address' => "Calle 1 # 2 Col. 345",
            'created_at' => now(),
            'updated_at' => now(),
            'role_id' => 2,
        ]);

        DB::table('users')->insert([
            'name' => 'Iglesia Central',
            'username' => 'um',
            'email' => 'um@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'phone' => "1234567890",
            'state' => "Sonora",
            'municipality' => "Hermosillo",
            'address' => "Calle 1 # 2 Col. 345",
            'created_at' => now(),
            'updated_at' => now(),
            'role_id' => 2,
        ]);
    }
}
