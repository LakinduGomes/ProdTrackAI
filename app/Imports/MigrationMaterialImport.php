<?php

namespace App\Imports;

use App\Models\MigrationMaterial;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MigrationMaterialImport implements ToModel , WithHeadingRow
{
    public function model(array $row)
    {

        $row = array_change_key_case($row, CASE_LOWER);
        return new MigrationMaterial([
            'material'=>$row['material'],
            'material_type'=>$row['material_type'],
            'plnt'=>$row['plnt'],
            'storage_location'=>$row['storage_location'],
            'material_description'=>$row['material_description'],
            'base_unit_of_measure'=>$row['base_unit_of_measure'],
            'matl_group'=>$row['matl_group'],
            'valuation_class'=>$row['valuation_class'],
            'profit_centre'=>$row['profit_centre'],
            'mrp'=>$row['mrp'],
            'typ'=>$row['typ'],
            'reorder_point'=>$row['reorder_point'],
            'max_lot_size'=>$row['max_lot_size'],
            'safety_stock'=>$row['safety_stock'],
            'created_by'=>$row['created_by'],
            'created'=>$row['created'],
            'last_chg'=>$row['last_chg'],
            'changed_by'=>$row['changed_by'],
            'client_level_block'=>$row['client_level_block'],
            'valid_to'=>$row['valid_to'],
            'pland_level_block'=>$row['pland_level_block'],
            'valuation_category'=>$row['valuation_category'],
            'valuation_type'=>$row['valuation_type']
        ]);
    }

}
