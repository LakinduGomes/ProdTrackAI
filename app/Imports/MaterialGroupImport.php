<?php

namespace App\Imports;

use App\Models\MaterialGroup;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MaterialGroupImport implements ToModel , WithHeadingRow
{
    public function model(array $row)
    {

        $row = array_change_key_case($row, CASE_LOWER);
        return new MaterialGroup([
            'form_type'      => $row['form_type'],
            'code'  => $row['code'],
            'name'  => $row['name'],
            'material_type'  => $row['material_type'],
        ]);
    }

}
