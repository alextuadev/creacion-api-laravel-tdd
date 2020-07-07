<?php

namespace Tests\Feature;

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
                ->assertJson(['name'=>'Carnitas'])
                ->assertStatus(201);

        $this->assertDatabaseHas('products', ['name'=>'Carnitas', 'price'=> 100]);
    }
}
