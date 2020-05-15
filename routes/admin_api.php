<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:admin_api'])->group(function () {
    Route::get('/config', 'ConfigController@config');
    Route::get('/admin-users/current', 'AdminUserController@current');
    Route::put('/admin-users/current', 'AdminUserController@updateCurrent');
    Route::apiResource('admin-users', 'AdminUserController');
    Route::apiResource('roles', 'RoleController');
    Route::apiResource('permissions', 'PermissionController');
    Route::put('/roles/{roles}/permissions', 'RoleController@updatePermissions');
});

