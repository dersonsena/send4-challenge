<?php

use Symfony\Component\HttpFoundation\Response;

class MeEndpointTest extends AuthTestCase
{
    /**
     * @var string
     */
    const URI = '/api/users/me';

    public function testMeWithAuthenticatedUser()
    {
        $payload = json_decode($this->actingAs($this->user)
            ->get(static::URI)
            ->seeStatusCode(Response::HTTP_OK)
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
