<?php

namespace App\Imports;

use App\Models\MaterialSubGroup4;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MaterialSubGroup4Import implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new MaterialSubGroup4([
            'code' => $row['code'],
            'name' => $row['name'],
        ]);
    }
}
