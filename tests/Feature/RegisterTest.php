<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    public function test_cannot_register_without_data(): void
    {
        $response = $this->jsonWithHeaders('POST', route('auth.register'));;

        $response->assertStatus(422)->assertJsonStructure(['message', 'errors']);
    }

    public function test_cannot_register_with_invalid_email(): void
    {
        $response = $this->jsonWithHeaders('POST', route('auth.register'), [
            'email' => 'Adewale'
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonFragment([
                'email' => ['The email field must be a valid email address.']
            ]);
    }

    public function test_cannot_register_without_name(): void
    {
        $response = $this->jsonWithHeaders('POST', route('auth.register'), [
            'email' => 'adewale@me.com'
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonFragment([
                'name' => ['The name field is required.']
            ]);
    }

    public function test_cannot_register_without_password(): void
    {
        $response = $this->jsonWithHeaders('POST', route('auth.register'), [
            'email' => 'adewale@me.com',
            'name' => 'adewale',
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonFragment([
                'password' => ['The password field is required.']
            ]);
    }

    public function test_cannot_register_with_short_password(): void
    {
        $response = $this->jsonWithHeaders('POST', route('auth.register'), [
            'email' => 'adewale@me.com',
            'name' => 'adewale',
            'password' => 'adewa',
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonFragment([
                'password' => ['The password field must be at least 6 characters.']
            ]);
    }

    public function test_guest_can_register(): void
    {
        $response = $this->jsonWithHeaders('POST', route('auth.register'), [
            'email' => 'adewale@me.com',
            'name' => 'adewale',
            'password' => 'adewale',
        ]);
        $response->assertSuccessful()
            ->assertJsonStructure(['success', 'message', 'data'])
            ->assertJson(['message' => 'Registration successful']);
    }
}
