<?php

namespace Database\Seeders;

use App\Imports\MaterialGroupImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class MaterialGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('master-data/material_group.xlsx'); // Adjust path
        Excel::import(new MaterialGroupImport(), $filePath);
        echo "✅ Data Imported Successfully!\n";
    }
}
