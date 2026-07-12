<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            ['code' => '1', 'name' => 'Common'],
            ['code' => '2', 'name' => 'Motorcycle'],
            ['code' => '3', 'name' => 'Scooter'],
            ['code' => '4', 'name' => '3Wheeler'],
            ['code' => '5', 'name' => 'Passenger Car']
        ];

        foreach ($data as $item) {
            Division::updateOrInsert(
                ['code' => $item['code']],
                ['name' => $item['name']]
            );
        }
    }
}
