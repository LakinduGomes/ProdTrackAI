<?php

namespace App\Repositories;

use App\Models\Brand;

class BrandRepository
{

    public function brand_list($request)
    {
        $brands = Brand::all();
        if ($request->is_admin == 0) {
            $brands = $brands->where('created_by', $request->created_by);
        }
        if(isset($request->status )){
            $brands = $brands->where('status', $request->status);
        }
        if(isset($request->user )){
            $brands = $brands->where('created_by', $request->user);
        }

        return $brands;
    }

    public function create($request)
    {

        $brand=new Brand();
        $brand->name = $request->name;
        $brand->code = $request->code;
        $brand->created_by = $request->created_by;
        $brand->status = $request->status == true ? 1 : 0;
        $brand->save();
   }

   public function update($request)
   {

        $brand=Brand::find($request->id);

        $brand->name = $request->name;
        $brand->code = $request->code;
        $brand->status = $request->status==true ? 1 : 0;
        $brand->updated_by = $request->updated_by;
        $brand->update();
   }

   public function view($request)
   {
        $brand = Brand::find($request->id);
        return $brand;
   }

   public function delete($request){

        $brand = Brand::find($request->id);

        if (!$brand) {
            return [
                'status' => false,
                'message' => 'Brand Not Found'
            ];
        }

        $brand->delete();

        return [
            'status' => true,
            'message' => 'Selected Brand Deleted Successfully!'
        ];
    }
}

