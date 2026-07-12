<?php

namespace App\Imports;

use App\Models\MaterialSubGroup2;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MaterialSubGroup2Import implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new MaterialSubGroup2([
            'code' => $row['code'],
            'name' => $row['name'],
        ]);
    }
}
