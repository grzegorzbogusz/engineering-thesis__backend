<?php

declare(strict_types=1);

namespace Tests\Feature\Account;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdatePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_password(): void
    {
        $data = [
            'old_password' => 'password',
            'new_password' => 'password123',
            'new_password_confirmation' => 'password123',
        ];

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->assertTrue(
            Hash::check($data['old_password'], $user->password)
        );

        $response = $this->putJson(
            route('change.password'),
            $data
        );

        $response->assertOk();
        $response->assertJson(['message' => 'Password updated']);

        $user = $user->refresh();

        $this->assertFalse(
            Hash::check($data['old_password'], $user->password)
        );

        $this->assertTrue(
            Hash::check($data['new_password'], $user->password)
        );
    }
}
