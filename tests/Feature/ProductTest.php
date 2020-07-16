<?php

namespace Tests\Feature;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function store_products()
    {
        $response = $this->post('/api/products', [
            "name" => "Carnitas",
            "price" => 100
        ]);

        $response->assertJsonStructure(["name", "price"])
            ->assertJson(['name' => 'Carnitas'])
            ->assertStatus(201);

        $this->assertDatabaseHas('products', ['name' => 'Carnitas', 'price' => 100]);
    }

    public function test_list_products()
    {
        factory(Product::class, 20)->create();

        $response = $this->get('/api/products');
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'price', 'created_at', 'updated_at']
            ]
        ])->assertStatus(200);
    }

    public function test_update_products()
    {
        $product = factory(Product::class)->create();

        $response = $this->json('PUT', "/api/products/$product->id", [
            "name" => "Carnitas repotenciadas",
            "price" => 500
        ]);

        $response->assertJsonStructure(["name", "price"])
            ->assertJson(['name' => 'Carnitas repotenciadas', 'price' => 500])
            ->assertStatus(200);

        $this->assertDatabaseHas('products', ['name' => 'Carnitas repotenciadas', 'price' => 500]);
    }
}
