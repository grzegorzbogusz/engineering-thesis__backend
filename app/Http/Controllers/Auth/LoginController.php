<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\UserLogin;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request, UserLogin $service): JsonResponse
    {
        $validated = $request->validated();

        $token = $service->logIn($validated);

        return response()->json(['Bearer' => $token]);
    }
}
