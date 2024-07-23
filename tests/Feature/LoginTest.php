<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    public function test_cannot_login_without_data(): void
    {
        $response = $this->jsonWithHeaders('POST', route('auth.login'));;

        $response->assertStatus(422)->assertJsonStructure(['message', 'errors']);
    }

    public function test_cannot_login_with_invalid_email(): void
    {
        $response = $this->jsonWithHeaders('POST', route('auth.login'), [
            'email' => 'Adewale'
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonFragment([
                'email' => ['The email field must be a valid email address.']
            ]);
    }

    public function test_cannot_login_with_new_email(): void
    {
        $response = $this->jsonWithHeaders('POST', route('auth.login'), [
            'email' => 'adewale@me.com'
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonFragment([
                'email' => ['Email address not found']
            ]);
    }

    public function test_cannot_login_without_password(): void
    {
        $user = User::factory()->create();
        $response = $this->jsonWithHeaders('POST', route('auth.login'), [
            'email' => $user->email,
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonFragment([
                'password' => ['The password field is required.']
            ]);
    }

    public function test_cannot_login_with_invalid_password(): void
    {
        $user = User::factory()->create();
        $response = $this->jsonWithHeaders('POST', route('auth.login'), [
            'email' => $user->email,
            'password' => 'adewa',
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['message'])
            ->assertJsonFragment([
                'message' => 'Invalid password'
            ]);
    }

    public function test_guest_can_login(): void
    {
        $user = User::factory()->create();
        $response = $this->jsonWithHeaders('POST', route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertSuccessful()
            ->assertJsonStructure(['success', 'message', 'data'])
            ->assertJson(['message' => 'Login successful']);
    }
}
