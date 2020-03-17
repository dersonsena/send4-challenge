<?php

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class FavoriteTest extends AuthTestCase
{
    /**
     * @var string
     */
    const URI = '/api/products/favorite/4543367512203';

    /**
     * @var string
     */
    const METHOD = 'POST';

    public function testFavoriteAction()
    {
        $this->actingAs($this->user)
            ->json(static::METHOD, static::URI)
            ->seeStatusCode(Response::HTTP_OK)
            ->seeJson([
                'status' => 'success',
                'data' => 'Product was favorited successfully.'
            ]);
    }

    public function testIfProductIsAlreadyFavorite()
    {
        DB::table('products_users')->insert([
            'user_id' => $this->user->id,
            'product_id' => 4543367512203
        ]);

        $this->actingAs($this->user)
            ->json(static::METHOD, static::URI)
            ->seeStatusCode(Response::HTTP_OK)
            ->seeJson([
                'status' => 'success',
                'data' => 'This product is already in your favorites list.'
            ]);
    }
}
