<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Account\AccountDeleter;
use Illuminate\Http\JsonResponse;

class UserManagementController extends Controller
{
    public function index(): JsonResponse
    {
        return response('Users here');
    }

    public function show(User $user): JsonResponse
    {
        
    }

    public function destroy(User $user, AccountDeleter $service): JsonResponse
    {
        $service->delete($user);

        return response()->json(['message' => 'Account deleted'], 200);
    }
}
