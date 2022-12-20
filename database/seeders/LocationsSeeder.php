<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Locations;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $input = [
                    [
                        'location' => 'Rooftop'
                    ],
                    [
                        'location' => 'Balcony'
                    ],
                    [
                        'location' => 'Ground Floor'
                    ],
                    [
                        'location' => 'Terrace'
                    ]
                 ];
        foreach ($input as $key => $value) {
            $role = Locations::create($value);
       }
    }
}
