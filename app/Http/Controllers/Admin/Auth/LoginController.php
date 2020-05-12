<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Authenticate user with credentials
     *
     * TODO: feature test
     * @param Request $request
     * @return array
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin_api')->attempt($credentials)) {
            return ['message' => 'success'];
        }

        abort(401, 'invalid credential');
    }

    public function logout()
    {
        Auth::guard('admin_api')->logout();
        return ['message' => 'success'];
    }
}
