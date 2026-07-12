<?php

namespace Database\Seeders;

use App\Models\MaterialType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Insert default material type
        $data = [
            [
                'code' => 'YFGS',
                'name' => 'Finished Goods-Manufacture Sri lanka',
                'status' => 1,
                'form_type' => 'FG/TRADING'
            ],
            [
                'code' => 'YTRD',
                'name' => 'Traded Goods',
                'status' => 1,
                'form_type' => 'FG/TRADING'
            ],
            [
                'code' => 'YSPR',
                'name' => 'SL Spares',
                'status' => 1,
                'form_type' => 'SL_VALUATED'
            ],
            [
                'code' => 'YADM',
                'name' => 'SL-Admin & Other Material',
                'status' => 1,
                'form_type' => 'SL_VALUATED'
            ],
            [
                'code' => 'YIND',
                'name' => 'SL Indirect/Packaging',
                'status' => 1,
                'form_type' => 'SL_VALUATED'
            ],
            [
                'code' => 'YCON',
                'name' => 'SL Consumables',
                'status' => 1,
                'form_type' => 'SL_VALUATED'
            ],
            [
                'code' => 'ZRAW',
                'name' => 'Raw Material',
                'status' => 1,
                'form_type' => 'SL_VALUATED'
            ],
            [
                'code' => 'YTOS',
                'name' => 'SL Tools',
                'status' => 1,
                'form_type' => 'SL_VALUATED'
            ],
            [
                'code' => 'YNST',
                'name' => 'SL Non Value Spare Materials',
                'status' => 1,
                'form_type' => 'SL_NON_VALUATED'
            ],
            [
                'code' => 'YNAD',
                'name' => 'SL Non Value Admin Materials',
                'status' => 1,
                'form_type' => 'SL_NON_VALUATED'
            ],
            [
                'code' => 'YEQP',
                'name' => 'SL-Equipment & Machinery',
                'status' => 1,
                'form_type' => 'SL_NON_VALUATED'
            ],
            [
                'code' => 'YADV',
                'name' => 'SL-Advert/Marketing/Promo',
                'status' => 1,
                'form_type' => 'SL_NON_VALUATED'
            ],
            [
                'code' => 'YSCR',
                'name' => 'SL Scrap Materials',
                'status' => 1,
                'form_type' => 'SL_NON_VALUATED'
            ]
        ];

        foreach ($data as $item) {
            MaterialType::updateOrInsert(
                ['code' => $item['code']], //check duplicate
                [
                    'name' => $item['name'],
                    'status' => $item['status'],
                    'form_type' => $item['form_type']
                ]
            );
        }
    }
}
