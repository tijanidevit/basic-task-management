<?php

namespace App\Services;

use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService {
    use ResponseTrait;

    public function __construct(protected User $user) {
    }

    public function login($data) : JsonResponse {

        if (!Auth::attempt($data)) {
            return $this->inputErrorResponse("Invalid password");
        }

        $user = auth()->user();
        $token = $user->createToken(config('auth.api_key'))->plainTextToken;
        return $this->successResponse("Login successful", compact('user', 'token'));

    }

    public function register($data) : JsonResponse {
        $data['password'] = Hash::make($data['password']);
        $user = $this->user->create($data);
        Auth::login($user);
        $token = $user->createToken(config('auth.api_key'))->plainTextToken;
        return $this->createdResponse("Registration successful", compact('user', 'token'));

    }
}
