<?php

namespace Database\Seeders;

use App\Imports\DistributionChannelImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Seeder;

class DistributionChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('master-data/distribution-channel.xlsx'); // Adjust path
        Excel::import(new DistributionChannelImport(), $filePath);
        echo "✅ Data Imported Successfully!\n";

    }
}
