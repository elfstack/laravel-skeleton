<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Utils\Listing;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws \Exception
     */
    public function index(Request $request)
    {
        return Listing::create(Permission::class)
            ->setColumns(['id', 'name', 'guard_name'])
            ->attachFiltering(['guard_type'])
            ->get($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions',
            'is_for_admin' => 'boolean|required'
        ]);

        return [
            'permission' => Permission::create([
                'guard_name' => $sanitized['is_for_admin'] ? 'admin_api' : 'api',
                'name' => $sanitized['name']
            ])
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param Permission $permission
     * @return array
     */
    public function show(Permission $permission)
    {
        return [
            'permission' => $permission
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Permission $permission
     * @return array
     */
    public function update(Request $request, Permission $permission)
    {
        $sanitized = $request->validate([
            'name' => 'required|string|unique:permissions'
        ]);

        return [
            'permission' => $permission->update($sanitized)
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Permission $permission
     * @return array
     * @throws \Exception
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return [ 'message' => 'success' ];
    }
}
