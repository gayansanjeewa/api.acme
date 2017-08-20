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

    /**
     * @test
     */
    public function it_lists_already_published_products()
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
                    'published_at' => $productOne->published_at,
                ],
            ]
        ];

        // When
        $response = $this->json('GET', 'api/product?display=published');

        // Then
        $response
            ->assertJson($json)
            ->assertDontSeeText($productTwo->name);
    }

    /**
     * @test
     */
    public function it_search_for_products_by_a_given_characters()
    {
        // Given
        $chair1 = factory(Product::class)->create(['name' => 'red chair']);
        $chair2 = factory(Product::class)->create(['name' => 'blue chair']);
        $table1 = factory(Product::class)->create(['name' => 'red table']);
        $table2 = factory(Product::class)->create(['name' => 'blue table']);

        // When
        $response = $this->json('GET', 'api/product?q=chair');

        // Then
        $response
            ->assertStatus(200)
            ->assertSeeText('chair')
            ->assertDontSeeText('table');
    }
}
