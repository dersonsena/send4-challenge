<?php

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class DisfavorTest extends AuthTestCase
{
    /**
     * @var string
     */
    const URI = '/api/products/disfavor/4543373377675';

    /**
     * @var string
     */
    const METHOD = 'POST';

    public function testDisfavoriteAction()
    {
        DB::table('products_users')->insert([
            'user_id' => $this->user->id,
            'product_id' => 4543373377675
        ]);

        $this->actingAs($this->user)
            ->json(static::METHOD, static::URI)
            ->seeStatusCode(Response::HTTP_OK)
            ->seeJson([
                'status' => 'success',
                'data' => 'Product was disfavored successfully.'
            ]);
    }

    public function testIfProductIsAlreadyDisfavorite()
    {
        $this->actingAs($this->user)
            ->json(static::METHOD, static::URI)
            ->seeStatusCode(Response::HTTP_OK)
            ->seeJson([
                'status' => 'success',
                'data' => "This product doesn't in your favorites list."
            ]);
    }
}
