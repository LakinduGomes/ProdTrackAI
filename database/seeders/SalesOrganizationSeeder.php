<?php

namespace Database\Seeders;

use App\Imports\SalesOrganizationImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Seeder;

class SalesOrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $filePath = base_path('master-data/sales-organization.xlsx'); // Adjust path
        Excel::import(new SalesOrganizationImport(), $filePath);
        echo "✅ Data Imported Successfully!\n";
    }

}
