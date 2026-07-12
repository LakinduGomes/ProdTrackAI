<?php

namespace Database\Seeders;

use App\Imports\UnitOfMeasureImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Seeder;

class UnitOfMeasureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('master-data/unit-of-measure.xlsx'); // Adjust path
        Excel::import(new UnitOfMeasureImport(), $filePath);
        echo "✅ Data Imported Successfully!\n";
    }
}
