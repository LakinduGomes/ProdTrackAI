<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            ['code' => 'LKR', 'name' => 'LKR'],
            ['code' => 'USD', 'name' => 'USD']
        ];

        foreach ($data as $item) {
            Currency::updateOrInsert(
                ['code' => $item['code']],
                ['name' => $item['name']]
            );
        }
    }
}
