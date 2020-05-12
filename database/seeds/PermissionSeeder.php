<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Role::create(['guard_name' => 'admin_api', 'name' => 'Super Admin']);

        Permission::create(['guard_name' => 'admin_api', 'name' => 'admin.admin-users']);
        Permission::create(['guard_name' => 'admin_api', 'name' => 'admin.roles']);

        $superAdmin->givePermissionTo(Permission::all());
    }
}
