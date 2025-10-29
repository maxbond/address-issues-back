<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\User\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if (! Auth::guard('web')->attempt(['email' => $email, 'password' => $password])) {
            return responseFailed(__('auth.failed'), 401);
        }

        $user = Auth::guard('web')->user();

        if (! $user->active) {
            return responseFailed(__("auth.forbidden"), 403);
        }

        $token = $user->createToken('login');

        return ['token' => $token->plainTextToken];
    }
}
