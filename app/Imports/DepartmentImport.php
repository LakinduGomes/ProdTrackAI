<?php

namespace App\Imports;

use App\Models\UserDepartment;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Section;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DepartmentImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new UserDepartment([
            'name' => $row['name']
        ]);
    }
}
