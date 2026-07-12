<?php

namespace Database\Seeders;

use App\Imports\SectionImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('master-data/sections.xlsx'); // Adjust path
        Excel::import(new SectionImport, $filePath);
        echo "✅ Data Imported Successfully!\n";
    }
}
