<?php

namespace App\Http\Controllers\Migration;

use App\Http\Controllers\Controller;
use App\Models\FGTrading;
use App\Models\FGTradingSupplyChain;
use App\Models\Material;
use App\Models\MigrationMaterial;
use App\Models\SlNonValuatedMaterial;
use App\Models\SlNonValuatedOrgdata;
use App\Models\SlValuatedMaterial;
use App\Models\SlValuatedOrgdata;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MigrationController extends Controller
{

    public function migrateFGMaterials()
    {
        set_time_limit(30000);

        //get material data
        $materials = DB::table('tbl_migration_material')
            ->where('main_sync_status', 'Pending')
            ->where('form_type', 'fg_trading')
            ->orderBy('material', 'asc')
            ->get();

        $fg_trading_id = 0;
        foreach ($materials as $material){

            $fg_materials = new FGTrading();
            $fg_materials_detail = new FGTradingSupplyChain();
            $common_material = new Material();

            $delete_flag = " ";
            if($material->client_level_block == "X" || $material->pland_level_block == "X"){
                $delete_flag = "Deleted";
            }

            // Check for duplicate material code
            $exists = DB::table('tbl_fg_trading')
                ->where('material_code', $material->material)
                ->exists();

            if(!$exists) {

                $history_array[0] = [
                    'action'     => 'Migrated',
                    'user'       => $material->changed_by,
                    'date'       => date('Y-m-d h:i:s'),
                    'ip_address' => 'SAP'
                ];
                $history = json_encode($history_array);

                $fg_materials->material_type = $material->material_type;
                $fg_materials->material_code = $material->material;
                $fg_materials->local_export = 'Local';
                $fg_materials->short_description = $material->material_description;
                $fg_materials->long_description = $material->material_description;
                $fg_materials->unit_of_measure = $material->base_unit_of_measure;
                $fg_materials->material_group = $material->matl_group;

                $fg_materials->division = null;
                $fg_materials->sub_group1 = null;
                $fg_materials->sub_group2 = null;
                $fg_materials->sub_group3 = null;
                $fg_materials->sub_group4 = null;
                $fg_materials->sub_group5 = null;
                $fg_materials->price = 0;
                $fg_materials->currency = "LKR";
                $fg_materials->valuation_class = $material->valuation_class;
                $fg_materials->weight = 0;
                $fg_materials->volume = 0;
                $fg_materials->nsd = 0;
                $fg_materials->special_note = "-";
                $fg_materials->approval_status = "Approved";
                $fg_materials->reject_reason = "-";
                $fg_materials->date_time = $material->last_chg;
                $fg_materials->current_level = 1;
                $fg_materials->next_level = 1;
                $fg_materials->level2_user = 1;
                $fg_materials->sync_status = "Yes";
                $fg_materials->created_at = date('Y-m-d');
                $fg_materials->updated_at = date('Y-m-d');
                $fg_materials->history = $history;
                $fg_materials->created_by = 1;

                $fg_materials->save();
                $fg_trading_id = $fg_materials->id;


                //update common material table
                $common_material->material_code = $material->material;
                $common_material->short_description = $material->material_description;
                $common_material->ref_id = $fg_trading_id;
                $common_material->delete_flag = $material->material;
                $common_material->delete_flag = $delete_flag;
                $common_material->form_type = "FG Trading";

                $common_material->save();

                //save plant info
                $fg_materials_detail->fg_trading_id = $fg_trading_id;
                $fg_materials_detail->plant = $material->plnt ?? null;
                if(!empty($material->storage_location)){
                    $fg_materials_detail->storage_location = $material->storage_location;
                }
                if(!empty($material->profit_centre)){
                    $fg_materials_detail->profit_center = $material->profit_centre;
                }


                //save supply chain data
                $fg_materials_detail->save();

            }
            else{

                //save plant info
                $fg_materials_detail->fg_trading_id = $fg_trading_id;
                $fg_materials_detail->plant = $material->plnt ?? null;
                if(!empty($material->storage_location)){
                    $fg_materials_detail->storage_location = $material->storage_location;
                }
                if(!empty($material->profit_centre)){
                    $fg_materials_detail->profit_center = $material->profit_centre;
                }

                //save supply chain data
                $fg_materials_detail->save();

            }

            //update status
            $material = MigrationMaterial::where('id', $material->id)->first();
            $material->update([
                'main_sync_status' => "sync"
            ]);

        }

        echo json_encode(array('status'=>TRUE));

    }

    public function migrateNONValuatedMaterials()
    {
        set_time_limit(30000);

        //get material data
        $materials = DB::table('tbl_migration_material')
            ->where('main_sync_status', 'Pending')
            ->where('form_type', 'non_valuated')
            ->orderBy('material', 'asc')
            ->get();

        $non_valuated_id = 0;
        foreach ($materials as $material){

            $non_materials = new SlNonValuatedMaterial();
            $non_materials_detail = new SlNonValuatedOrgdata();
            $common_material = new Material();

            $delete_flag = " ";
            if($material->client_level_block == "X" || $material->pland_level_block == "X"){
                $delete_flag = "Deleted";
            }

            // Check for duplicate material code
            $exists = DB::table('tbl_material_non_valuated')
                ->where('material_code', $material->material)
                ->exists();

            if(!$exists) {

                $history_array[0] = [
                    'action'     => 'Migrated',
                    'user'       => $material->changed_by,
                    'date'       => date('Y-m-d h:i:s'),
                    'ip_address' => 'SAP'
                ];
                $history = json_encode($history_array);

                $non_materials->material_type = $material->material_type;
                $non_materials->material_code = $material->material;
                $non_materials->short_description = $material->material_description;
                $non_materials->long_description = $material->material_description;
                $non_materials->base_uom = $material->base_unit_of_measure;
                $non_materials->safety_stock = $material->base_unit_of_measure;
                $non_materials->mrp_type = $material->typ;
                $non_materials->lot_sizing = $material->max_lot_size;

                $non_materials->material_group = $material->matl_group;

                $non_materials->special_note = "-";
                $non_materials->approval_status = "Approved";
                $non_materials->reject_reason = "-";
                $non_materials->date_time = $material->last_chg;
                $non_materials->current_level = 1;
                $non_materials->next_level = 1;
                $non_materials->sync_status = "Yes";
                $non_materials->created_at = date('Y-m-d');
                $non_materials->updated_at = date('Y-m-d');
                $non_materials->history = $history;
                $non_materials->created_by = 1;

                $non_materials->save();
                $non_valuated_id = $non_materials->id;


                //update common material table
                $common_material->material_code = $material->material;
                $common_material->short_description = $material->material_description;
                $common_material->ref_id = $non_valuated_id;
                $common_material->delete_flag = $material->material;
                $common_material->delete_flag = $delete_flag;
                $common_material->form_type = "FG Trading";

                $common_material->save();

                //save plant info
                $non_materials_detail->non_valuated_id = $non_valuated_id;
                $non_materials_detail->plant = $material->plnt ?? null;
                if(!empty($material->storage_location)){
                    $non_materials_detail->storage_location = $material->storage_location;
                }
                if(!empty($material->profit_centre)){
                    $non_materials_detail->profit_center = $material->profit_centre;
                }


                //save supply chain data
                $non_materials_detail->save();

            }
            else{

                //save plant info
                $non_materials_detail->non_valuated_id = $non_valuated_id;
                $non_materials_detail->plant = $material->plnt ?? null;
                if(!empty($material->storage_location)){
                    $non_materials_detail->storage_location = $material->storage_location;
                }
                if(!empty($material->profit_centre)){
                    $non_materials_detail->profit_center = $material->profit_centre;
                }

                //save supply chain data
                $non_materials_detail->save();

            }

            //update status
            $material = MigrationMaterial::where('id', $material->id)->first();
            $material->update([
                'main_sync_status' => "sync"
            ]);

        }

        echo json_encode(array('status'=>TRUE));
    }

    public function migrateValuatedMaterials()
    {

        set_time_limit(30000);

        //get material data
        $materials = DB::table('tbl_migration_material')
            ->where('main_sync_status', 'Pending')
            ->where('form_type', 'valuated')
            ->orderBy('material', 'asc')
            ->get();

        $valuated_id = 0;
        foreach ($materials as $material){

            $valuated_materials = new SlValuatedMaterial();
            $valuated_materials_detail = new SlValuatedOrgdata();
            $common_material = new Material();

            $delete_flag = " ";
            if($material->client_level_block == "X" || $material->pland_level_block == "X"){
                $delete_flag = "Deleted";
            }

            // Check for duplicate material code
            $exists = DB::table('tbl_material_valuated')
                ->where('material_code', $material->material)
                ->exists();

            if(!$exists) {

                $history_array[0] = [
                    'action'     => 'Migrated',
                    'user'       => $material->changed_by,
                    'date'       => date('Y-m-d h:i:s'),
                    'ip_address' => 'SAP'
                ];
                $history = json_encode($history_array);

                $valuated_materials->material_type = $material->material_type;
                $valuated_materials->material_code = $material->material;
                $valuated_materials->short_description = $material->material_description;
                $valuated_materials->long_description = $material->material_description;
                $valuated_materials->base_uom = $material->base_unit_of_measure;
                $valuated_materials->safety_stock = $material->base_unit_of_measure;
                $valuated_materials->mrp_type = $material->typ;
                $valuated_materials->lot_sizing = $material->max_lot_size;

                $valuated_materials->material_group = $material->matl_group;

                $valuated_materials->special_note = "-";
                $valuated_materials->approval_status = "Approved";
                $valuated_materials->reject_reason = "-";
                $valuated_materials->date_time = $material->last_chg;
                $valuated_materials->current_level = 1;
                $valuated_materials->next_level = 1;
                $valuated_materials->sync_status = "Yes";
                $valuated_materials->created_at = date('Y-m-d');
                $valuated_materials->updated_at = date('Y-m-d');
                $valuated_materials->history = $history;
                $valuated_materials->created_by = 1;

                $valuated_materials->save();
                $valuated_id = $valuated_materials->id;


                //update common material table
                $common_material->material_code = $material->material;
                $common_material->short_description = $material->material_description;
                $common_material->ref_id = $valuated_id;
                $common_material->delete_flag = $material->material;
                $common_material->delete_flag = $delete_flag;
                $common_material->form_type = "Valuated";

                $common_material->save();

                //save plant info
                $valuated_materials_detail->valuated_id = $valuated_id;
                $valuated_materials_detail->plant = $material->plnt ?? null;
                if(!empty($material->storage_location)){
                    $valuated_materials_detail->storage_location = $material->storage_location;
                }
                if(!empty($material->profit_centre)){
                    $valuated_materials_detail->profit_center = $material->profit_centre;
                }


                //save supply chain data
                $valuated_materials_detail->save();

            }
            else{

                //save plant info
                $valuated_materials_detail->valuated_id = $valuated_id;
                $valuated_materials_detail->plant = $material->plnt ?? null;
                if(!empty($material->storage_location)){
                    $valuated_materials_detail->storage_location = $material->storage_location;
                }
                if(!empty($material->profit_centre)){
                    $valuated_materials_detail->profit_center = $material->profit_centre;
                }

                //save supply chain data
                $valuated_materials_detail->save();

            }

            //update status
            $material = MigrationMaterial::where('id', $material->id)->first();
            $material->update([
                'main_sync_status' => "sync"
            ]);

        }

        echo json_encode(array('status'=>TRUE));
    }

}
