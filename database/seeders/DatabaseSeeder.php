<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([RoleSeeder::class, UsersTableSeeder::class]);

        Member::Factory(90)->create();

    }
}
