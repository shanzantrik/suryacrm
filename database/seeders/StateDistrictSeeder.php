<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;
use App\Models\District;

class StateDistrictSeeder extends Seeder
{
    public function run()
    {
        // Create the state of Assam
        $state = State::create(['name' => 'Assam']);

        // List of districts in Assam
        $districts = [
            'Baksa',
            'Barpeta',
            'Biswanath',
            'Bongaigaon',
            'Cachar',
            'Charaideo',
            'Chirang',
            'Darrang',
            'Dhemaji',
            'Dhubri',
            'Dibrugarh',
            'Goalpara',
            'Golaghat',
            'Hailakandi',
            'Hojai',
            'Jorhat',
            'Kamrup Metropolitan',
            'Kamrup Rural',
            'Karbi Anglong',
            'Karimganj',
            'Kokrajhar',
            'Lakhimpur',
            'Majuli',
            'Morigaon',
            'Nagaon',
            'Nalbari',
            'Dima Hasao',
            'Sivasagar',
            'Sonitpur',
            'South Salmara-Mankachar',
            'Tinsukia',
            'Udalguri',
            'West Karbi Anglong',
        ];

        // Loop through each district and create it for the state of Assam
        foreach ($districts as $districtName) {
            District::create(['name' => $districtName, 'state_id' => $state->id]);
        }
    }
}
