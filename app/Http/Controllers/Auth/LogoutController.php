<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\UserLogout;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke(Request $request, UserLogout $service): JsonResponse
    {
        $token = $request->user()->currentAccessToken();

        $service->logout($token);

        return new JsonResponse();
    }
}
