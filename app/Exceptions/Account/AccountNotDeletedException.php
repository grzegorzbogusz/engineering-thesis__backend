<?php

declare(strict_types=1);

namespace App\Exceptions\Account;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class AccountNotDeletedException extends HttpResponseException
{
    public function __construct()
    {
        parent::__construct(
            new JsonResponse(['message' => 'Account not deleted'], 500)
        );
    }   
}
