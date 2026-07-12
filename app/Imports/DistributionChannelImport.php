<?php

namespace App\Imports;


use App\Models\DistributionChannel;
use App\Models\SalesOrganization;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DistributionChannelImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new DistributionChannel([
            'code' => $row['code'],
            'name' => $row['name'],
        ]);
    }
}
