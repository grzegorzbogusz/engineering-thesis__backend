<?php

declare(strict_types = 1);

namespace App\Services\Auth;

use App\Exceptions\Auth\UserNotLoggedInException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserLogin
{
    public function logIn(array $validated): string
    {
        $user = User::whereEmail($validated['email'])->first();

        if(!$user || !Hash::check($validated['password'], $user->password)) {
            throw new UserNotLoggedInException();
        }

        return $user->createToken()->plainTextToken;;
    }
}