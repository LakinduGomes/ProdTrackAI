<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['first_name' => 'super', 'last_name' => 'admin', 'email' => 'admin@gmail.com', 'level'=>999,'password' => Hash::make('Admin@1234'),'status' => 1],
            ['first_name' => 'Kasun', 'last_name' => 'De Mel', 'email' => 'kasun@gateonesoft.lk','level'=>1,'password' => Hash::make('Admin@1234'),'status' => 1]
        ];

        foreach ($data as $item) {
            User::updateOrInsert(
                ['email' => $item['email']], //Check  by email
                [ // Update or insert these fields
                    'first_name' => $item['first_name'],
                    'last_name' => $item['last_name'],
                    'password' => $item['password'],
                    'level' => $item['level'],
                    'status' => $item['status']
                ]
            );
        }

    }
}
