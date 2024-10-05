<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {
    }

    public function login(LoginRequest $request) : RedirectResponse {
        if (!Auth::attempt($request->validated())) {
            return back()->withErrors([
                'password' => 'Invalid password.',
            ])->withInput($request->except('password'));
        }

        return to_route('home');

    }

    public function logout() : RedirectResponse {
        Auth::logout();
        return to_route('login');

    }
}
