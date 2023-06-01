<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

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

        Product::create([
            'name' => 'Producto 1',
            'price' => 10
        ]);

        $response = $this->get(route('products.index'));

        $response->assertStatus(200);

        $response->assertViewIs('products.index');

        $response->assertViewHas('products', Product::all());

        $response->assertDontSee('No se encontraron productos');
    }

    public function test_can_create_a_new_product(): void
    {
        $product = [
            'name' => 'producto #1',
            'price' => 25
        ];

        $response = $this->post('/products', $product);

        $response->assertStatus(302);

        $response->assertRedirect(route('products.index'));

        $this->assertDatabaseCount('products', 1);

        $lastProductCreated = Product::query()->latest()->first();

        // $this->assertDatabaseHas('products', [
        //     'name' => $lastProductCreated->name,
        //     'price' => $lastProductCreated->price
        // ]);

        $this->assertDatabaseHas('products', $product);

        $this->assertEquals($product['name'], $lastProductCreated->name);
        $this->assertEquals($product['price'], $lastProductCreated->price);
    }

    public function test_can_edit_a_product(): void
    {
        $product = Product::create([
            'name' => 'Product #1',
            'price' => 100
        ]);

        $response = $this->put('/products/' . $product->id, [
            'name' => 'producto editado',
            'price' => 200
        ]);

        $response->assertStatus(302);

        $response->assertRedirect(route('products.index'));

        $this->assertDatabaseCount('products', 1);

        $lastProductUpdated = Product::query()->latest()->first();

        $this->assertEquals('producto editado', $lastProductUpdated->name);
        $this->assertEquals(200, $lastProductUpdated->price);
    }

    public function test_delete_product_successful()
    {

        $product = Product::factory()->create();

        $response = $this->delete('/products/' . $product->id);

        $response->assertStatus(302);

        $this->assertDatabaseCount('products', 0);

        $this->assertDatabaseMissing('products', $product->toArray());
    }
}
