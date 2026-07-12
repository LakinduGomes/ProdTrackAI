<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{

    public function category_list($request)
    {

        $brands = Category::all();
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

        $category=new Category();
        $category->name = $request->name;
        $category->code = $request->code;
        $category->created_by = $request->created_by;
        $category->status = $request->status == true ? 1 : 0;
        $category->save();
   }

   public function update($request)
   {

        $category=Category::find($request->id);

        $category->name = $request->name;
        $category->code = $request->code;
        $category->status = $request->status==true ? 1 : 0;
        $category->updated_by = $request->updated_by;
        $category->update();
   }

   public function delete($request){

        $brand = Category::find($request->id);

        if (!$brand) {
            return [
                'status' => false,
                'message' => 'Category Not Found'
            ];
        }

        $brand->delete();

        return [
            'status' => true,
            'message' => 'Selected Category Deleted Successfully!'
        ];
    }
}

