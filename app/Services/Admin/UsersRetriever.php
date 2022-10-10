<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class UsersRetriever
{
    public static function get(): array|Arrayable|JsonSerializable
    {
        return new UserCollection(
            User::withoutAdmin()->cursorPaginate(10)
        );
    }
}