<?php

namespace Database\Seeders;

use App\Imports\ProfitCenterImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Seeder;

class ProfitCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('master-data/profit-center.xlsx'); // Adjust path
        Excel::import(new ProfitCenterImport(), $filePath);
        echo "✅ Data Imported Successfully!\n";
    }
}
