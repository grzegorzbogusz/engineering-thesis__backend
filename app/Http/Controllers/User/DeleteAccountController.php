<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Account\AccountDeleter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteAccountController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        AccountDeleter::delete($request->user());

        return response()->json(['message' => 'Account deleted'], 200);
    }
}
