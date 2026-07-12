<?php

namespace App\Repositories;

use App\Models\Item;

class ItemRepository
{

    public function item_list($request)
    {
        $items = Item::all();
        if ($request->is_admin == 0) {
            $items = $items->where('created_by', $request->created_by);
        }
        if(isset($request->status )){
            $items = $items->where('status', $request->status);
        }
        if(isset($request->user )){
            $items = $items->where('created_by', $request->user);
        }


        return $items;
    }

    public function create($request)
    {

        $item = new Item();
        $item->name = $request->name;
        $item->code = $request->code;
        $item->created_by = $request->created_by;
        $item->brand_id = $request->brand;
        $item->category_id = $request->category;
        $item->status = $request->status == true ? 1 : 0;
        $item->save();
   }

   public function update($request)
   {

        $item=Item::find($request->id);

        $item->name = $request->name;
        $item->code = $request->code;
        $item->brand_id = $request->brand;
        $item->category_id = $request->category;
        $item->status = $request->status==true ? 1 : 0;
        $item->updated_by = $request->updated_by;
        $item->update();
   }

   public function delete($request){

        $item = Item::find($request->id);

        if (!$item) {
            return [
                'status' => false,
                'message' => 'Item Not Found'
            ];
        }

        $item->delete();

        return [
            'status' => true,
            'message' => 'Selected Item Deleted Successfully!'
        ];
    }
}
