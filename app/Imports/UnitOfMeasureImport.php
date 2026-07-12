<?php

namespace App\Imports;

use App\Models\UnitOfMeasure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UnitOfMeasureImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new UnitOfMeasure([
            'code' => $row['code'],
            'name' => $row['name'],
        ]);
    }
}
