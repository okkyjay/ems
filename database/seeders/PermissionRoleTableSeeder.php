<?php

namespace Database\Seeders;

use App\EMS\Permission\Permission;
use App\EMS\Role\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));
    }
}
