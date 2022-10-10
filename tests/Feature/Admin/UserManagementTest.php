<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_retrieve_paginated_users(): void
    {
        $jsonStructur = [
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'is_active',
                ],
            ],
            'links' => [
                'first',
                'last',
                'prev',
                'next',
            ],
            'meta' => [
                'path',
                'per_page',
                'next_cursor',
                'prev_cursor',
            ],
        ];

        $this->seed();

        $admin = User::where('is_admin', 1)->first();
        Sanctum::actingAs($admin);

        $response = $this->getJson(
            route('users.index')
        );

        $response->assertStatus(200);
        $response->assertJsonStructure($jsonStructur);

        $nextCursor = $response->json('meta.next_cursor');

        $response = $this->getJson(
            route('users.index', ['cursor' => $nextCursor])
        );

        $response->assertOk();
        $response->assertJsonStructure($jsonStructur);
    }

    public function test_user_can_not_retrieve_paginated_users(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->getJson(
            route('users.index')
        );

        $response->assertForbidden();
    }

    public function test_admin_can_retrieve_user_details(): void
    {
        $this->seed();

        $admin = User::where('is_admin', 1)->first();
        Sanctum::actingAs($admin);

        $user = User::withoutAdmin()->first();

        $response = $this->getJson(
            route('users.show', $user->id)
        );

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'email_verified_at',
            'created_at',
            'updated_at',
        ]);
    }

    public function test_user_can_not_retrieve_another_user_details(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $user = User::factory()->create();

        $response = $this->getJson(
            route('users.show', $user->id)
        );

        $response->assertForbidden();
    }

    public function test_admin_can_delete_user_account(): void
    {
        $this->seed();

        $admin = User::where('is_admin', 1)->first();
        Sanctum::actingAs($admin);

        $user = User::withoutAdmin()->first();

        $this->assertModelExists($user);

        $response = $this->deleteJson(
            route('users.destroy', $user->id)
        );

        $response->assertOk();
        $response->assertJson(['message' => 'Account deleted']);

        $this->assertModelMissing($user);
    }

    public function test_admin_account_can_not_be_deleted(): void
    {
        $this->seed();

        $admin = User::where('is_admin', 1)->first();
        Sanctum::actingAs($admin);

        $response = $this->deleteJson(
            route('users.destroy', $admin->id)
        );

        $response->assertUnprocessable();
        $this->assertModelExists($admin);
    }

    public function test_user_can_not_delete_another_user_account(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $user = User::factory()->create();

        $response = $this->deleteJson(
            route('users.destroy', $user->id)
        );

        $response->assertForbidden();
        $this->assertModelExists($user);
    }
}
