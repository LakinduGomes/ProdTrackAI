<?php

namespace App\Imports;

use App\Models\SalesOrganization;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SalesOrganizationImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new SalesOrganization([
            'code' => $row['code'],
            'name' => $row['name'],
        ]);
    }
}
