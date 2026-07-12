<?php

namespace Database\Seeders;

use App\Imports\MaterialSubGroup1Import;
use App\Imports\MaterialSubGroup2Import;
use App\Imports\MaterialSubGroup3Import;
use App\Imports\MaterialSubGroup4Import;
use App\Imports\MaterialSubGroup5Import;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\MaterialSubGroup2;
use Illuminate\Database\Seeder;

class MaterialSubGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $filePath = base_path('master-data/material-sub-group1.xlsx'); // Adjust path
        Excel::import(new MaterialSubGroup1Import(), $filePath);
        echo "✅ Data Imported Successfully!\n";

        $filePath = base_path('master-data/material-sub-group2.xlsx'); // Adjust path
        Excel::import(new MaterialSubGroup2Import(), $filePath);
        echo "✅ Data Imported Successfully!\n";

        $filePath = base_path('master-data/material-sub-group3.xlsx'); // Adjust path
        Excel::import(new MaterialSubGroup3Import(), $filePath);
        echo "✅ Data Imported Successfully!\n";

        $filePath = base_path('master-data/material-sub-group4.xlsx'); // Adjust path
        Excel::import(new MaterialSubGroup4Import(), $filePath);
        echo "✅ Data Imported Successfully!\n";

        $filePath = base_path('master-data/material-sub-group5.xlsx'); // Adjust path
        Excel::import(new MaterialSubGroup5Import(), $filePath);
        echo "✅ Data Imported Successfully!\n";

    }
}
