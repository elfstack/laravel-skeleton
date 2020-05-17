<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Utils\Listing;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */

    public function __construct()
    {
        $this->middleware('can:admin.admin-users')->except('current', 'updateCurrent');
    }

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
            'email' => [
                'required',
                'email',
                'unique:admin_users'
            ],
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
            'email' => [
                'required',
                'email',
                Rule::unique('admin_users')->ignore($adminUser->id)
            ],
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
     * @param AdminUser $adminUser
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(AdminUser $adminUser)
    {
        $adminUser->delete();
        return response()->noContent();
    }

    /**
     * Retrieve current logged in admin_user
     *
     * @param Request $request
     * @return array
     */
    public function current(Request $request)
    {
        $adminUser = $request->user();

        $adminUser->avatar_url = $adminUser->getFirstMediaUrl('avatars', 'avatar');

        $adminUser->roles = $adminUser->roles()->pluck('name');

        return [
            'admin_user' => $adminUser
        ];
    }

    /**
     * Update current logged in admin_user
     * @param Request $request
     * @param AdminUser $adminUser
     * @return array
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function updateCurrent(Request $request) {
        $adminUser = $request->user();

        $sanitized = $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('admin_users')->ignore($adminUser->id)
            ],
            'avatar_path' => 'sometimes',
            'password' => 'sometimes|min:6'
        ]);

        if ($request->has('password')) {
            $sanitized['password'] = Hash::make($sanitized['password']);
        }

        if ($request->has('avatar_path')) {
            $adminUser->addMediaFromDisk($request->input('avatar_path'))
                ->toMediaCollection('avatars');
        }

        $adminUser->update($sanitized);

        return [
            'admin_user' => $adminUser
        ];
    }
}
