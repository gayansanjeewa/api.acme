<?php

namespace Tests\Feature;

use App\Product;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ListProductTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_lists_all_products()
    {
        // Given
        $productOne = factory(Product::class)->create();
        $productTwo = factory(Product::class)->create(['published_at' => Carbon::now()->addDays(7)]);
        $json = [
            'products' => [
                [
                    'id' => $productOne->id,
                    'name' => $productOne->name,
                    'price' => $productOne->price,
                    'status' => $productOne->status,
                    'user_id' => $productOne->user_id,
                ],
                [
                    'id' => $productTwo->id,
                    'name' => $productTwo->name,
                    'price' => $productTwo->price,
                    'status' => $productTwo->status,
                    'user_id' => $productTwo->user_id,
                ]

            ]
        ];

        // When
        $response = $this->json('GET', 'api/product');

        // Then
        $response->assertJson($json);
    }
}
