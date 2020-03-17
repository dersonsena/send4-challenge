<?php

use Symfony\Component\HttpFoundation\Response;

class RegisterEndpointTest extends AuthTestCase
{
    /**
     * @var string
     */
    const URI = '/api/users/register';

    /**
     * @var string
     */
    const METHOD = 'POST';

    public function testRegistrationWithoutParams()
    {
        $this->actingAs($this->user)
            ->json(static::METHOD, static::URI, [])
            ->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->seeJson([
                'name' => ['The name field is required.'],
                'email' => ['The email field is required.'],
                'password' => ['The password field is required.']
            ]);
    }

    public function testRegistrationUser()
    {
        $testUser = [
            'name' => 'Test User',
            'email' => md5(uniqid(rand(), true)) . '@domain.com',
            'password' => 'secret'
        ];

        $payload = json_decode($this->actingAs($this->user)
            ->json(static::METHOD, static::URI, $testUser)
            ->seeStatusCode(Response::HTTP_OK)
            ->response
            ->getContent());

        $this->assertTrue(true, property_exists($payload, 'status'));
        $this->assertEquals('success', $payload->status);

        $this->assertTrue(property_exists($payload, 'data'));
        $this->assertTrue(property_exists($payload->data, 'name'));
        $this->assertTrue(property_exists($payload->data, 'email'));
        $this->assertTrue(property_exists($payload->data, 'updated_at'));
        $this->assertTrue(property_exists($payload->data, 'created_at'));
        $this->assertTrue(property_exists($payload->data, 'id'));
        $this->assertEquals($testUser['name'], $payload->data->name);
        $this->assertEquals($testUser['email'], $payload->data->email);
    }
}
