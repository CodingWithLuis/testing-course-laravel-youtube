<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_can_see_the_empty_products_table(): void
    {
        // $response = $this->get('/products');

        $response = $this->get(route('products.index'));

        $response->assertStatus(200);

        $response->assertViewIs('products.index');

        $response->assertViewHas('products', Product::all());

        $response->assertSee('No se encontraron productos');
    }

    public function test_can_see_the_non_empty_products_table(): void
    {
        // $response = $this->get('/products');

        $response = $this->get(route('products.index'));

        $response->assertStatus(200);

        $response->assertViewIs('products.index');

        $response->assertViewHas('products', Product::all());

        $response->assertDontSee('No se encontraron productos');
    }
}
