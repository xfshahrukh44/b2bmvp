<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;
use App\Models\Admin;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // roles
        DB::table('roles')->insert([
            'name' => 'admin',
            'guard_name' => 'admin',
        ]);
        DB::table('roles')->insert([
            'name' => 'buyer',
            'guard_name' => 'buyer',
        ]);
        DB::table('roles')->insert([
            'name' => 'seller',
            'guard_name' => 'seller',
        ]);
        
        // admins
        DB::table('admins')->insert([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@b2b.com',
            'password' => Hash::make('temp'),
            'phone' => '12345678',
        ]);
        $admin = Admin::find(1);
        $admin->assignRole('admin');

        // provinces and cities
        DB::table('provinces')->insert([
            'name' => 'Sindh'
        ]);
        DB::table('provinces')->insert([
            'name' => 'Punjab'
        ]);
        DB::table('provinces')->insert([
            'name' => 'Khyber Pakhtunkhwa'
        ]);
        DB::table('provinces')->insert([
            'name' => 'Balochistan'
        ]);
        DB::table('provinces')->insert([
            'name' => 'Federal'
        ]);
        DB::table('provinces')->insert([
            'name' => 'Gilgit-Baltistan'
        ]);
        DB::table('provinces')->insert([
            'name' => 'Azad Kashmir'
        ]);
        populate_cities_table();

        // \App\Models\User::factory(10)->create();
    }
}
