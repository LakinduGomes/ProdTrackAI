<?php

namespace Database\Seeders;

use App\Models\PurchasingOrderUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchasingOrderUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //tbl_master_material_purchasing_order_unit
        $data = [
            ['code' => 'no','name' => 'numbers'],
            ['code' => 'M','name' => 'Meter']
        ];

        foreach ($data as $item) {
            PurchasingOrderUnit::updateOrInsert(
                ['code' => $item['code']],
                ['name' => $item['name']],
            );
        }
    }
}
