<?php

namespace App\Imports;

use App\Models\Modules;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ModulesImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        return new Modules([
            'name' => $row['name'],
            'path' => $row['path'],
            'section' => $row['section'],
        ]);
    }
}
