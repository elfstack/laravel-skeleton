<?php

use Illuminate\Support\Facades\Route;

Route::get('/admin', function () {
    return view('admin');
});

Route::post('/admin/api/login', 'Auth\LoginController@authenticate');
Route::get('/admin/api/logout', 'Auth\LoginController@logout');
