<?php
namespace App\Imports;

use App\Models\MasterPlant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MasterPlantImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new MasterPlant([
            'code' => $row['code'],  // Adjust to match your column names
            'name' => $row['name'],
            'status' => $row['status'],
        ]);
    }
}

?>