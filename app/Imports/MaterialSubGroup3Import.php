<?php

namespace App\Imports;

use App\Models\MaterialSubGroup3;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MaterialSubGroup3Import implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new MaterialSubGroup3([
            'code' => $row['code'],
            'name' => $row['name'],
        ]);
    }
}
