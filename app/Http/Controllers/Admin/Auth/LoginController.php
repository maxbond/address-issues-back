<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class LoginController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware(RedirectIfAuthenticated::class, except: ['logout']),
        ];
    }

    public function index()
    {
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if (! Auth::guard('web')->attempt(['email' => $email, 'password' => $password])) {
            return back()->withErrors(['failed' => __('auth.failed')])->withInput();
        }

        $user = Auth::guard('web')->user();
        abort_if(! $user->active, 403);

        return redirect(route('admin.dashboard'));
    }

    public function logout()
    {
        Auth::guard('web')->logout();

        return redirect(route('login'));
    }
}
