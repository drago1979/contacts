<?php

namespace Database\Seeders;

use App\Models\PhoneNumber;
use Illuminate\Database\Seeder;

class PhoneNumbersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PhoneNumber::create([
            'contact_id' => 1,
            'description' => 'Home',
            'number' => '0112345678'
        ]);

        PhoneNumber::create([
            'contact_id' => 1,
            'description' => 'Office',
            'number' => '0222345678'
        ]);

        PhoneNumber::create([
            'contact_id' => 2,
            'description' => 'Work',
            'number' => '0112345678'
        ]);

        PhoneNumber::create([
            'contact_id' => 2,
            'description' => 'Private',
            'number' => '0642345678'
        ]);
    }
}
