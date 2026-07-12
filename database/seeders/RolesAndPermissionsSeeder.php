<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create Permissions
        Permission::create(['name' => 'Create']);
        Permission::create(['name' => 'Edit']);
        Permission::create(['name' => 'Rejected']);

        Permission::create(['name' => 'Level1 Approved']);

        Permission::create(['name' => 'Level2 Approved']);
        Permission::create(['name' => 'Level2 Rejected']);

        Permission::create(['name' => 'Level3 Approved']);
        Permission::create(['name' => 'Level3 Rejected']);

        Permission::create(['name' => 'Level4 Approved']);
        Permission::create(['name' => 'Level4 Rejected']);

        Permission::create(['name' => 'Level5 Approved']);
        Permission::create(['name' => 'Level5 Rejected']);


        // Create Roles and Assign Permissions
        $admin = Role::create(['name' => 'Admin']);
        $level1 = Role::create(['name' => 'Level1']);
        $level2 = Role::create(['name' => 'Level2']);
        $level3 = Role::create(['name' => 'Level3']);
        $level4 = Role::create(['name' => 'Level4']);
        $level5 = Role::create(['name' => 'Level5']);

        //give permission for admin
        $admin->givePermissionTo(['Create','Edit']);
        
        //give permission for requester
        $level1->givePermissionTo(['Create','Edit','Level1 Approved']);
        $level2->givePermissionTo(['Level2 Approved','Rejected']);
        $level3->givePermissionTo(['Level3 Approved','Rejected']);
        $level4->givePermissionTo(['Level4 Approved','Rejected']);
        $level5->givePermissionTo(['Level5 Approved','Rejected']);

    }
}
