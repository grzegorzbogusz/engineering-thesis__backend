<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Services\Auth\UserRegistrar;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class RegisterUserController extends Controller
{
    public function __invoke(RegisterUserRequest $request, UserRegistrar $service): JsonResponse
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = $service->register($validated);

        event(new Registered($user));

        return response()->json(status: 201);
    }
}
