<?php

namespace App\Imports;

use App\Models\ProfitCenter;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProfitCenterImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new ProfitCenter([
            'code' => $row['code'],
            'name' => $row['name'],
            'plant' => $row['plant'],
        ]);
    }
}
