<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.roles');
    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        return [
            'roles' => Role::all()
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $sanitized = $request->validate([
            'name' => 'required|string|unique:roles',
            'is_for_admin' => 'boolean|required'
        ]);

        return [
            'role' => Role::create([
                'guard_name' => $sanitized['is_for_admin'] ? 'admin_api' : 'api',
                'name' => $sanitized['name']
            ])
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return array
     */
    public function show(Role $role)
    {
        $role->permissions = $role->permissions()->pluck('id');
        $role->total_users = $role->users()->count();
        return [
            'role' => $role,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Role $role
     * @return array
     */
    public function update(Request $request, Role $role)
    {
        $sanitized = $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('roles')->ignore($role->id)
            ],
            'permissions' => 'required|array'
        ]);

        $role->permissions()->sync($sanitized['permissions']);

        unset($sanitized['permissions']);

        return [
            'role' => $role->update($sanitized)
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return array
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return [ 'message' => 'success' ];
    }

    /**
     * Update permission for given role
     * @param Request $request
     * @param Role $role
     * @return array
     */
    public function updatePermissions(Request $request, Role $role)
    {
        $sanitized = $request->validate([
            'permissions' => 'array'
        ]);

        $role->permissions()->sync($sanitized['permissions']);

        return ['message' => 'success'];
    }
}
