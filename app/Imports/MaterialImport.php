<?php

namespace App\Imports;

use App\Models\Material;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MaterialImport implements ToModel , WithHeadingRow
{
    public function model(array $row)
    {

        $row = array_change_key_case($row, CASE_LOWER);
        return new Material([
            'material_code'      => $row['material_code'],
            'short_description'  => $row['short_description'],
            'delete_flag'  => $row['delete_flag'],
        ]);
    }

}
