<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Redirector;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {
    }

    public function login(LoginRequest $request) : JsonResponse | Redirector {
        if ($request->wantsJson()) {
            return $this->authService->login($request->validated());
        }

    }
}
