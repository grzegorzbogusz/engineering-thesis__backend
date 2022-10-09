<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Exceptions\Auth\UserNotCreatedException;
use App\Models\User;
use Throwable;

class UserRegistrar
{
    public function register(array $validated): User
    {
        try {
            $user = User::create($validated);
        } catch(Throwable) {
            throw new UserNotCreatedException();
        }

        return $user;
    }
}