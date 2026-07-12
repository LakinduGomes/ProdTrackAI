<?php

namespace App\Imports;

use App\Models\FGTradingMass;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FGTradingMassImport implements ToModel, WithHeadingRow
{
    /**
     * Map and import data into FGTradingMass model.
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new FGTradingMass([
            'request_type' => $row['request_type'] ?? null,  // Correct key-based access
            'material_code' => $row['material_code'] ?? null,
            'material_type' => $row['material_type'] ?? null,
            'plant' => $row['plant'] ?? null,
            'storage_location' => $row['storage_location'] ?? null,
            'material_group' => $row['material_group'] ?? null,
            'short_description' => $row['material_short_description'] ?? null,
            'unit_of_measure' => $row['unit_of_measure'] ?? null,
            'valuation_class' => $row['valuation_class'] ?? null,
            'profit_center' => $row['profit_center'] ?? null,
            'date_time' => now(),  // More Laravel-idiomatic timestamp
            'current_level' => 1,
            'next_level' => 1,
        ]);
    }

    /**
     * Define the start row to skip unnecessary headers (Excel heading row logic).
     */
    public function startRow(): int
    {
        return 10;  // Skip first 9 rows
    }
}
