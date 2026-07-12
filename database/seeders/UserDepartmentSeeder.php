<?php

namespace Database\Seeders;

use App\Imports\DepartmentImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Seeder;

class UserDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('master-data/department.xlsx'); // Adjust path
        Excel::import(new DepartmentImport, $filePath);
        echo "✅ Data Imported Successfully!\n";
    }
}
