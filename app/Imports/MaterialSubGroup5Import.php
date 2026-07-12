<?php

namespace App\Imports;

use App\Models\MaterialSubGroup5;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MaterialSubGroup5Import implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new MaterialSubGroup5([
            'code' => $row['code'],
            'name' => $row['name'],
        ]);
    }
}
