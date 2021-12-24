<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::create([
            'last_name' => 'LaRusso',
            'first_name' => 'Danny'
        ]);

        Contact::create([
            'last_name' => 'Miyagi',
            'first_name' => 'Sensei'
        ]);
    }
}
