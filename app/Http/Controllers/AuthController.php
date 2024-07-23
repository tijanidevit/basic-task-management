<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {
    }

    public function login(LoginRequest $request) : JsonResponse {
        return $this->authService->login($request->validated());
    }

    public function register(RegisterRequest $request) : JsonResponse {
        return $this->authService->register($request->validated());
    }
}
