<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\User;

class UsersRetriever
{
    public static function get(): mixed
    {
        return User::withoutAdmin()->cursorPaginate(10);
    }
}