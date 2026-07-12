<?php

namespace Database\Seeders;

use App\Imports\ModulesImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('master-data/modules.xlsx'); // Adjust path
        Excel::import(new ModulesImport(), $filePath);
        echo "✅ Data Imported Successfully!\n";
    }
}
