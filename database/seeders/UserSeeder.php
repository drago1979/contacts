<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        User - Admin
        User::create([
            'is_admin' => 1,
            'name' => 'orson',
            'email' => 'orson@gmail.com',
            'password' => 'password'
        ]);

//        User - regular
        User::create([
            'is_admin' => 0,
            'name' => 'francis',
            'email' => 'francis@gmail.com',
            'password' => 'password'
        ]);
    }
}
