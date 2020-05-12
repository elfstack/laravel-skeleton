<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:admin_api'])->group(function () {
    Route::get('/admin-users/current', 'AdminUserController@current');
    Route::resource('admin-users', 'AdminUserController');
});

