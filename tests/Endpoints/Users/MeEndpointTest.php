<?php

use App\Domain\User\User;

class MeEndpointTest extends TestCase
{
    /**
     * @var string
     */
    const URI = '/api/users/me';

    /**
     * @var User
     */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory('App\Domain\User\User')->create();
    }

    public function testMeWithAuthenticatedUser()
    {
        $payload = json_decode($this->actingAs($this->user)
            ->get(static::URI)
            ->seeStatusCode(200)
            ->response
            ->getContent());

        $this->assertTrue(property_exists($payload, 'status'));
        $this->assertEquals('success', $payload->status);

        $this->assertTrue(property_exists($payload, 'data'));
        $this->assertTrue(property_exists($payload->data, 'id'));
        $this->assertTrue(property_exists($payload->data, 'name'));
        $this->assertTrue(property_exists($payload->data, 'email'));
        $this->assertTrue(property_exists($payload->data, 'created_at'));
        $this->assertTrue(property_exists($payload->data, 'updated_at'));
    }
}
