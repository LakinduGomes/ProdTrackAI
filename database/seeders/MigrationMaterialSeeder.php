<?php

namespace Database\Seeders;

use App\Imports\MaterialImport;
use App\Imports\MigrationMaterialImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Seeder;

class MigrationMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('master-data/material/migration-material.xlsx'); // Adjust path
        Excel::import(new MigrationMaterialImport(), $filePath);
        echo "✅ Data Imported Successfully!\n";
    }
}
