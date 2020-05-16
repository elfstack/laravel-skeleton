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
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function run()
    {
        $this->resetPermissions();

        Permission::create(['guard_name' => 'admin_api', 'name' => 'admin.admin-users']);
        Permission::create(['guard_name' => 'admin_api', 'name' => 'admin.roles']);
        Permission::create(['guard_name' => 'admin_api', 'name' => 'admin.audits']);

        Role::findByName('Super Admin', 'admin_api')->givePermissionTo(Permission::all());
    }

    /**
     * Reset all permissions
     */
    private function resetPermissions()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Schema::disableForeignKeyConstraints();
        DB::table('role_has_permissions')->truncate();
        DB::table('permissions')->truncate();
        Schema::enableForeignKeyConstraints();
    }
}
