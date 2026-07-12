<?php

namespace Database\Seeders;

use App\Models\BudgetType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BudgetTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            ['code' => 'Capex'],
            ['code' => 'Apex'],
        ];

        foreach ($data as $item) {
            BudgetType::updateOrInsert(
                ['code' => $item['code']]
            );
        }
    }
}
