<?php

namespace App\Imports;

use App\Models\MaterialValuationClass;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ValuationClassImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new MaterialValuationClass([
            'code' => $row['code'],
            'name' => $row['name'],
            'material_group' => $row['material_group'],
        ]);
    }
}
