<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Role::create(['guard_name' => 'admin_api', 'name' => 'Super Admin']);
        $superAdmin->givePermissionTo(Permission::all());
    }
}
