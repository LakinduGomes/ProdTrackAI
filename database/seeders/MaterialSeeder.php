<?php

namespace Database\Seeders;

use App\Imports\MaterialImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('master-data/materials.xlsx'); // Adjust path
        Excel::import(new MaterialImport, $filePath);
        echo "✅ Data Imported Successfully!\n";
    }
}
