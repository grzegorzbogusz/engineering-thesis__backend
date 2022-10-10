<?php

declare(strict_types=1);

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteAccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_account(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $this->assertModelExists($user);

        $response = $this->deleteJson(
            route('delete.account')
        );

        $response->assertOk();
        $this->assertModelMissing($user);
    }
}
