<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Http\Resources\UserResource;
use App\Models\User;

class UsersRetriever
{
    public static function get(): mixed
    {
        return UserResource::collection(
            User::withoutAdmin()->cursorPaginate(10)
        );
    }
}