<?php

namespace App\Imports;

use App\Models\StorageLocation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StorageLocationImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new StorageLocation([
            'code' => $row['code'],
            'name' => $row['name'],
            'form_type' => $row['form_type'],
        ]);
    }
}
