<?php

namespace Database\Seeders;

use App\Imports\StorageLocationImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Seeder;

class StorageLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('master-data/storage-location.xlsx'); // Adjust path
        Excel::import(new StorageLocationImport(), $filePath);
        echo "✅ Data Imported Successfully!\n";
    }
}
