<?php

namespace Database\Seeders;

use App\Models\BaseUnitOfMeasure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BaseUnitOfMeasureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = [
            ['code' => 'no','name' => 'numbers'],
            ['code' => 'M','name' => 'Meter'],
            ['code' => 'ST','name' => 'ITEMS / SET'],
            ['code' => 'KG','name' => 'Kilogram'],
            ['code' => 'L','name' => 'Liter'],
            ['code' => 'PAA','name' => 'Pair'],
            ['code' => 'M2','name' => 'Square meter'],
            ['code' => 'EA','name' => 'each']
        ];

        foreach ($data as $item) {
            BaseUnitOfMeasure::updateOrInsert(
                ['code' => $item['code']],
                ['name' => $item['name']],
            );
        }
    }
}
