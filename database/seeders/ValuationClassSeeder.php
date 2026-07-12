<?php

namespace Database\Seeders;

use App\Imports\ValuationClassImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Seeder;

class ValuationClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('master-data/valuation-class.xlsx'); // Adjust path
        Excel::import(new ValuationClassImport(), $filePath);
        echo "✅ Data Imported Successfully!\n";
    }
}
