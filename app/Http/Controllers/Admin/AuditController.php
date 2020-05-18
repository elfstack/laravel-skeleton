<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Utils\Listing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
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
        $hasTimeFilter = $request->has('from') && $request->has('to');

        $range = [];

        if ($hasTimeFilter) {
            $range = [
                Carbon::parse($request->input('from')),
                Carbon::parse($request->input('to'))
            ];
        }

        return Listing::create(Audit::class)
            ->attachFiltering(['user_id', 'tags', 'event'])
            ->attachSorting(['created_at'], 'created_at', 'desc')
            ->modifyQuery(function ($query) use ($hasTimeFilter, $range){
                // TODO: filter user output
                $query->with('user');
                if ($hasTimeFilter) {
                    $query->whereBetween('created_at', $range);
                }
            })
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Audit  $audit
     * @return \Illuminate\Http\Response
     */
    public function show(Audit $audit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Audit  $audit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Audit $audit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Audit  $audit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Audit $audit)
    {
        //
    }
}
