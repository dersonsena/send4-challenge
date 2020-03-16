<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class LoginEndpointTest extends TestCase
{
    public function testLoginWithoutParams()
    {
        $this->json('GET', '/api/auth/login', [])
            ->seeJson([
                'email' => ['The email field is required.'],
                'password' => ['The password field is required.']
            ]);
    }

    public function testLoginWithEmptyParams()
    {
        $this->json('GET', '/api/auth/login', ['email' => '', 'password' => ''])
            ->seeJson([
                'email' => ['The email field is required.'],
                'password' => ['The password field is required.']
            ]);
    }
}

