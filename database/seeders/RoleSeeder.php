<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Roles;

class RoleSeeder extends Seeder
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
                        'name' => 'Super Admin',
                        'description'=>'All Controles'
                    ],
                    [
                        'name' => 'Admin',
                        'description'=>'All Controles'
                    ],
                    [
                        'name' => 'Customer',
                        'description'=>'Limited data can see'
                    ]
                 ];
        foreach ($input as $key => $value) {
            $role = Roles::create($value);
       }
        //$admin = Role::create($input);
    }
}
