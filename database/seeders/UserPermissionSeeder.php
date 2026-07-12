<?php

namespace Database\Seeders;

use App\Imports\UserPermissionImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Seeder;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('master-data/user-permission.xlsx'); // Adjust path
        Excel::import(new UserPermissionImport(), $filePath);
        echo "✅ Data Imported Successfully!\n";
    }
}
