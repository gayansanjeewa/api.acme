<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_creates_a_product()
    {
        // Given
        $this->signUp();
        $payload = [
            'data' => [
                'product' => [
                    'user_id' => $this->user->id,
                    'name' => 'Red Chair',
                    'price' => 10000,
                    'publish' => null
                ]
            ]
        ];

        // When
        $response = $this->post('api/product', $payload, $this->headers);

        // Then
        $response->assertStatus(200);
        $this->assertDatabaseHas('products', [
            'user_id' => $this->user->id,
            'name' => 'Red Chair',
            'price' => 10000
        ]);
    }
}
