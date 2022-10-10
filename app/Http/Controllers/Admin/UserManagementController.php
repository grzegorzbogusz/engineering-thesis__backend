<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Account\AccountDeleter;
use App\Services\Admin\UsersRetriever;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;
use JsonSerializable;

class UserManagementController extends Controller
{
    public function index(): array|Arrayable|JsonSerializable
    {
        return UsersRetriever::get();
    }

    public function show(User $user): JsonResponse
    {
        if ($user->isAdmin()) {
            abort(400, 'Admin account can not be selected');
        }

        return response()->json($user);
    }

    public function destroy(User $user): JsonResponse
    {
        AccountDeleter::delete($user);

        return response()->json(['message' => 'Account deleted'], 200);
    }
}
