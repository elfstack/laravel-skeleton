<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Utils\Listing;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return LengthAwarePaginator
     * @throws \Exception
     */

    public function index(Request $request)
    {
        $result = Listing::create(AdminUser::class)
            ->attachSorting(['id'])
            ->attachSearching(['name'])
            ->modifyQuery(function ($query) {
                $query->with('roles:name');
            })
            ->get($request);

        // TODO: unset pivot

        return $result;

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
            'name' => 'required',
            'email' => 'required',
            'password' => 'min:6|required',
            'roles' => 'array|required'
        ]);

        $sanitized['password'] = Hash::make($sanitized['password']);

        $adminUser = AdminUser::create($sanitized);
        $adminUser->roles()->sync($sanitized['roles']);

        return [
            'admin_user' => $adminUser
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param AdminUser $adminUser
     * @return array
     */
    public function show(AdminUser $adminUser)
    {
        $adminUser->roles = $adminUser->roles()->pluck('id');

        return [
            'admin_user' => $adminUser
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param AdminUser $adminUser
     * @return array
     */
    public function update(Request $request, AdminUser $adminUser)
    {
        $sanitized = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'sometimes|min:6',
            'roles' => 'array|required'
        ]);

        if ($request->has('password')) {
            $sanitized['password'] = Hash::make($sanitized['password']);
        }

        $adminUser->roles()->sync($sanitized['roles']);

        $adminUser->update($sanitized);

        return [
            'admin_user' => $adminUser
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //TODO: postponed
    }

    public function current(Request $request)
    {
        return [
            'admin_user' => $request->user()
        ];
    }
}
