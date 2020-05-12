<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Utils\Listing;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TODO:
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function current(Request $request)
    {
        return [
            'admin_user' => $request->user()
        ];
    }
}
