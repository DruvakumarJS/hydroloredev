<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

use Illuminate\Support\Facades\Hash;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $admin = User::create([
                    'name' => 'SuperAdmin',
                    'email' =>'admin@admin.com',
                    'role_id'=>'1',
                    'password' => Hash::make('admin')
                ]);

    }
}
