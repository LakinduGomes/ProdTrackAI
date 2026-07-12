<?php

namespace App\Repositories;

use App\Models\MasterMaterial;

class MasterMaterialRepository
{

    public function plant_list($request)
    {
        $plants = MasterMaterial::all();
        if ($request->is_admin == 0) {
            $items = $plants->where('created_by', $request->created_by);
        }
        if(isset($request->status )){
            $items = $plants->where('status', $request->status);
        }
        if(isset($request->user )){
            $items = $plants->where('created_by', $request->user);
        }


        return $plants;
    }

    public function create($request)
    {

        $plant = new MasterMaterial();
        $plant->name = $request->name;
        $plant->code = $request->code;
        $plant->created_by = $request->created_by;
        $plant->brand_id = $request->brand;
        $plant->category_id = $request->category;
        $plant->status = $request->status == true ? 1 : 0;
        $plant->save();
    }

    public function update($request)
    {

        $plant=MasterMaterial::find($request->id);

        $plant->name = $request->name;
        $plant->code = $request->code;
        $plant->brand_id = $request->brand;
        $plant->category_id = $request->category;
        $plant->status = $request->status==true ? 1 : 0;
        $plant->updated_by = $request->updated_by;
        $plant->update();
    }

    public function delete($request){

        $plant = MasterMaterial::find($request->id);

        if (!$plant) {
            return [
                'status' => false,
                'message' => 'Plant Not Found'
            ];
        }

        $plant->delete();

        return [
            'status' => true,
            'message' => 'Selected Item Deleted Successfully!'
        ];
    }
}

