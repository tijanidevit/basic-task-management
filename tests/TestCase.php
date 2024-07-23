<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
    }

    protected function getAuthorizationToken(User $user)
    {
        return $this->jsonWithHeaders('POST', route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ])->getOriginalContent()['data']['token'];
    }


    protected function jsonWithHeaders($method, $uri, array $data = [], array $headers = [])
    {
        $defaultHeaders = ['x-api-key' => 'kokoro'];
        $headers = array_merge($defaultHeaders, $headers);

        return $this->json($method, $uri, $data, $headers);
    }
}
