<?php

namespace App\Imports;

use App\Models\UserPermission;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserPermissionImport implements ToModel , WithHeadingRow
{
    public function model(array $row)
    {

        $row = array_change_key_case($row, CASE_LOWER);
        return new UserPermission([
            'user'      => $row['user'],
            'module'  => $row['module'],
        ]);
    }

}
