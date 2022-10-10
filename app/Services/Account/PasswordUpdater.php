<?php

declare(strict_types=1);

namespace App\Services\Account;

use App\Exceptions\User\PasswordNotUpdatedException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Throwable;

class PasswordUpdater
{
    public static function update(User $user, string $newPassword): void
    {
        if(! $user->exists) {
            abort(404, 'Account does not exists');
        }
        
        try {
            $user->password = Hash::make($newPassword);
            $user->save();
        } catch (Throwable) {
            throw new PasswordNotUpdatedException();
        }
    }
}