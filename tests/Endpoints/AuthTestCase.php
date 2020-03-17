<?php

use App\Domain\User\User;
use Symfony\Component\HttpFoundation\Response;

class AuthTestCase extends TestCase
{
    /**
     * @var string
     */
    const URI = '/';

    /**
     * @var string
     */
    const METHOD = 'GET';

    /**
     * @var User
     */
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory('App\Domain\User\User')->create();
    }

    public function testWithoutAuth()
    {
        $response = $this->call(static::METHOD, static::URI);

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->status());
        $this->assertEquals('Unauthorized.', $response->getContent());
    }
}
