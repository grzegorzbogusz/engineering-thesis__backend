<?php

declare(strict_types=1);

namespace App\Services\Account;

use App\Exceptions\Account\AccountNotDeletedException;
use App\Models\User;
use Throwable;

class AccountDeleter
{
    public function delete(User $user): void
    {
        if($user->isAdmin()) {
            abort(400, 'Admin account can not be deleted');
        }

        if(! $user->exists) {
            abort(400, 'Account does not exists');
        }

        try {
            throw_unless($user->delete());
        } catch (Throwable) {
            throw new AccountNotDeletedException();
        }
    }
}