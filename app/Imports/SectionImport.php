<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Section;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SectionImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Section([
            'name' => $row['name'],
            'icon' => $row['icon'],
        ]);
    }
}
