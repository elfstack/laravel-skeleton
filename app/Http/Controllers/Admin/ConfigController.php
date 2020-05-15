<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class ConfigController extends Controller
{
    public function config() {
        $permission = app()->make(PermissionRegistrar::class)
            ->getPermissions()
            ->pluck('roles.*.name', 'name');

        return [
            'permissions' => $permission
        ];
    }

    /**
     * TODO: query config version
     */
    public function version() {
    }
}
