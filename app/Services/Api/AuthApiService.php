<?php

namespace App\Services\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthApiService
{
    public function register(array $validatedData): JsonResponse
    {
        $user = User::create($validatedData);
        $token = $user->createToken('auth_token')->plainTextToken;

        return successResponse(
            message: 'User created successfully',
            data: [
                'user' => $user,
                'token' => $token,
            ]
        );
    }

    public function login(array $credentials)
    {
        if (! auth()->attempt(credentials: $credentials)) {
            return failureResponse(
                message: 'Invalid credentials',
                code: 401
            );
        }

        $user = auth()->user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return successResponse(
            message: 'User logged in successfully',
            data: [
                'user' => $user,
                'token' => $token,
            ]
        );
    }

    public function isLoggedIn(): JsonResponse
    {
        if (! auth()->check()) {
            return failureResponse(
                message: 'User is not logged in',
                code: 401
            );
        }

        $user = auth()->user();

        return successResponse(
            message: 'User is logged in',
            data: [
                'user' => $user,
            ]
        );
    }

    public function logout(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();

        return successResponse(
            message: 'User logged out successfully'
        );
    }
}
