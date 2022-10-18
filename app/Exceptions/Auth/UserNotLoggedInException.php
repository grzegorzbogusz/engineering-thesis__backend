<?php

declare(strict_types=1);

namespace App\Exceptions\Auth;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UserNotLoggedInException extends HttpResponseException
{
    public function __construct()
    {
        parent::__construct(
            new JsonResponse(['email' => ['Incorrect email or password']], 422)
        );
    }
}
