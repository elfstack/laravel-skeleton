<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Mockery\Generator\StringManipulation\Pass\Pass;

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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'remember' => 'sometimes|boolean'
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->input('remember');

        if (Auth::guard('admin_api')->attempt($credentials, $remember)) {
            return ['message' => 'success'];
        }

        abort(401, 'invalid credential');
    }

    /**
     * Logout current user
     *
     * @return JsonResponse
     */
    public function logout()
    {
        Auth::guard('admin_api')->logout();
        return response()->json([
            'message' => 'success'
        ]);
    }

    /**
     * Send a reset password email to admin user
     * @param Request $request
     * @return JsonResponse
     */
    public function sendResetPasswordEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        if ($response == PASSWORD::INVALID_USER) {
            return response()->json(['message' => 'failed'], 404);
        } else {
            return response()->json(['message' => 'success']);
        }
    }

    /**
     * Verify whether the reset password token is correct
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function verifyResetPasswordToken(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required'
        ]);

        $response = $this->validateReset(
            $request->only('email', 'token')
        );

        return response()->json([
            'message' => ($response != Password::INVALID_TOKEN || $response != Password::INVALID_USER)
                ? 'success' : 'failed'
        ]);
    }

    /**
     * Reset user password if token is correct
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:6'
        ]);

        $response = $this->broker()->reset(
            $request->only('email', 'token', 'password'),
            function (AdminUser $adminUser, string $password) {
                $adminUser->password = Hash::make($password);
                $adminUser->save();
            }
        );

        if ($response != Password::PASSWORD_RESET) {
            return response()->json([
                'message' => 'failed'
            ], 410);
        }

        return response()->json([
            'message' => 'success'
        ]);
    }

    private function broker()
    {
        return Password::broker('admin_users');
    }

    /**
     * Validate a password reset for the given credentials.
     * This method exists in PasswordBroker, but is protected
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\CanResetPassword|string
     */
    private function validateReset(array $credentials)
    {
        if (is_null($user = $this->broker()->getUser($credentials))) {
            return Password::INVALID_USER;
        }

        if (! $this->broker()->getRepository()->exists($user, $credentials['token'])) {
            return Password::INVALID_TOKEN;
        }

        return $user;
    }
}
