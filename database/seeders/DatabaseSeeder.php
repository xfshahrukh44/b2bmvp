<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@b2b.com',
            'password' => Hash::make('temp'),
            'phone' => '12345678',
        ]);

        // \App\Models\User::factory(10)->create();
    }
}
