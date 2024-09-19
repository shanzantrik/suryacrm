<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('members')->insert([
            [
                'name' => 'Radhe Shyam',
                'date_of_anniversary' => Carbon::create('1985', '10', '15'), // Example Date
                'phone' => '00000-00000',
                'email' => 'xyz@suryagoldcement.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Shantanu Goswami',
                'date_of_anniversary' => Carbon::create('1990', '05', '10'), // Example Date
                'phone' => '11111-11111',
                'email' => 'abc@suryagoldcement.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'John Doe',
                'date_of_anniversary' => Carbon::create('2000', '12', '25'), // Example Date
                'phone' => '22222-22222',
                'email' => 'john.doe@suryagoldcement.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Doe',
                'date_of_anniversary' => Carbon::create('1995', '08', '20'), // Example Date
                'phone' => '33333-33333',
                'email' => 'jane.doe@suryagoldcement.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more entries as needed
        ]);
    }
}
