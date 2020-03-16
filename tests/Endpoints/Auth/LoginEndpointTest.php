<?php

class LoginEndpointTest extends TestCase
{
    /**
     * @var string
     */
    const URI = '/api/auth/login';

    /**
     * @var string
     */
    const METHOD = 'GET';

    public function testLoginWithoutParams()
    {
        $this->json(static::METHOD, static::URI, [])
            ->seeStatusCode(422)
            ->seeJson([
                'email' => ['The email field is required.'],
                'password' => ['The password field is required.']
            ]);
    }

    public function testLoginWithEmptyParams()
    {
        $this->json(static::METHOD, static::URI, ['email' => '', 'password' => ''])
            ->seeStatusCode(422)
            ->seeJson([
                'email' => ['The email field is required.'],
                'password' => ['The password field is required.']
            ]);
    }

    public function testLoginWithEmailOnly()
    {
        $this->json(static::METHOD, static::URI, ['email' => 'foo@domain.com'])
            ->seeStatusCode(422)
            ->seeJson([
                'password' => ['The password field is required.']
            ]);
    }

    public function testLoginWithPasswordOnly()
    {
        $this->json(static::METHOD, static::URI, ['password' => 'foo'])
            ->seeStatusCode(422)
            ->seeJson([
                'email' => ['The email field is required.'],
            ]);
    }

    public function testLoginWithInvalidCredentials()
    {
        $this->json(static::METHOD, static::URI, ['email' => 'wrong@domain.com', 'password' => '123'])
            ->seeStatusCode(401)
            ->seeJson(['message' => 'Unauthorized User']);
    }

    public function testLoginWithValidCredentials()
    {
        $fakeUser = factory('App\Domain\User\User')->create();

        $payload = json_decode($this->json('GET', static::URI, ['email' => $fakeUser->email, 'password' => 'secret'])
            ->seeStatusCode(200)
            ->response
            ->getContent());

        $this->assertTrue(property_exists($payload, 'status'));
        $this->assertEquals('success', $payload->status);

        $this->assertTrue(property_exists($payload, 'data'));
        $this->assertTrue(property_exists($payload->data, 'token'));
        $this->assertTrue(property_exists($payload->data, 'token_type'));
        $this->assertTrue(property_exists($payload->data, 'expires_in'));

        $this->assertEquals(320, strlen($payload->data->token));
        $this->assertEquals('bearer', $payload->data->token_type);
        $this->assertEquals(3600, $payload->data->expires_in);
    }
}

