<?php

namespace App\Repositories;

use Spatie\Permission\Models\Permission;

class PermissionRepository
{

    public function permission_list($request)
    {
        $permissions = Permission::all();
        return $permissions;
    }

    public function create($request)
    {

        $permission=new Permission();

        $permission->name = $request->name;
        $permission->save();
   }

   public function update($request)
   {

       $permission=Permission::find($request->id);

       $permission->name = $request->name;
       $permission->update();
   }

   public function view($request)
   {
       $permission = Brand::find($request->id);
        return $permission;
   }

   public function delete($request){

       $permission = Brand::find($request->id);

        if (!$permission) {
            return [
                'status' => false,
                'message' => 'Permission Not Found'
            ];
        }

       $permission->delete();

        return [
            'status' => true,
            'message' => 'Deleted Successfully!'
        ];
    }
}

