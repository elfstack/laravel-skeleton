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
        return Listing::create(AdminUser::class)
            ->attachSorting(['id'])
            ->attachSearching(['name'])
            ->get($request);
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
        ]);

        $sanitized['password'] = Hash::make($sanitized['password']);

        return [
            'admin_user' => AdminUser::create($sanitized)
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
        ]);

        if ($request->has('password')) {
            $sanitized['password'] = Hash::make($sanitized['password']);
        }

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
