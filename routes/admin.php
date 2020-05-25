<?php

use Illuminate\Support\Facades\Route;

Route::get('/admin', function () {
    return view('admin-app');
});

// TODO: change path prefix to /admin/api/admin-users/login
Route::post('/admin/api/login', 'Auth\LoginController@authenticate');
Route::get('/admin/api/logout', 'Auth\LoginController@logout');

Route::prefix('/admin/api/admin-users')->group(function () {
    Route::post('password/reset-token', 'Auth\LoginController@sendResetPasswordEmail');
    Route::post('password/reset-token/verify', 'Auth\LoginController@verifyResetPasswordToken');
    Route::put('password', 'Auth\LoginController@resetPassword');
});
