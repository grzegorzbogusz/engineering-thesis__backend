<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_can_be_requested()
    {
        Notification::fake();

        $user = User::factory()->create();

        $response = $this->postJson(route('password.email'), [
            'email' => $user->email
        ]);

        $response->assertOk();

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_password_can_be_reset_with_valid_token()
    {
        Notification::fake();

        $user = User::factory()->create();

        $response = $this->postJson(route('password.email'), [
            'email' => $user->email
        ]);

        $response->assertOk();

        $this->assertFalse(
            Hash::check('password123', $user->password)
        );

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
            $response = $this->post(route('password.update'), [
                'token' => $notification->token,
                'email' => $user->email,
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ]);

            $response->assertOk();

            return true;
        });

        $this->assertTrue(
            Hash::check('password', $user->password)
        );
    }
}
