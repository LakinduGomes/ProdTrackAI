<?php

namespace App\Imports;

use App\Models\MaterialSubGroup1;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MaterialSubGroup1Import implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new MaterialSubGroup1([
            'code' => $row['code'],
            'name' => $row['name'],
            'material_group' => $row['material_group'],
            'form_type' => $row['form_type'],
        ]);
    }
}
