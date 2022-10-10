<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\UpdatePasswordRequest;
use App\Services\Account\PasswordUpdater;
use Illuminate\Http\JsonResponse;

class UpdatePasswordController extends Controller
{
    public function __invoke(UpdatePasswordRequest $request): JsonResponse
    {
        $newPassword = $request->validated('new_password');

        PasswordUpdater::update(
            $request->user(),
            $newPassword
        );

        return response()->json(['message' => 'Password updated']);
    }
}
