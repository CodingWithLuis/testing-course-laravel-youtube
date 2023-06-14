<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    private function createNewUser($is_admin = 0): User
    {
        $user = User::factory()->create([
            'email' => $is_admin ? 'admin@admin.com' : 'user@user.com',
            'password' => bcrypt('password'),
            'is_admin' => $is_admin
        ]);

        return $user;
    }

    public function test_an_admin_can_see_the_empty_products_table(): void
    {
        // $response = $this->get('/products');

        $user = $this->createNewUser(1);

        $response = $this->actingAs($user)->get(route('products.index'));

        $response->assertStatus(200);

        $response->assertViewIs('products.index');

        $response->assertViewHas('products', Product::all());

        $response->assertSee('No se encontraron productos');
    }

    public function test_a_guest_user_cannot_see_the_empty_products_table(): void
    {
        // $response = $this->get('/products');

        $user = $this->createNewUser(0);

        $response = $this->actingAs($user)->get(route('products.index'));

        $response->assertStatus(404);
    }

    public function test_can_see_the_non_empty_products_table(): void
    {
        $user = $this->createNewUser(1);

        Product::create([
            'name' => 'Producto 1',
            'price' => 10
        ]);

        $response = $this->actingAs($user)->get(route('products.index'));

        $response->assertStatus(200);

        $response->assertViewIs('products.index');

        $response->assertViewHas('products', Product::all());

        $response->assertDontSee('No se encontraron productos');
    }

    public function test_can_create_a_new_product(): void
    {
        $this->user = $this->createNewUser(1);

        $product = [
            'name' => 'producto #1',
            'price' => 25
        ];

        $response = $this->actingAs($this->user)->post('/products', $product);

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
        $user = $this->createNewUser(1);

        $product = Product::create([
            'name' => 'Product #1',
            'price' => 100
        ]);

        $response = $this->actingAs($user)->put('/products/' . $product->id, [
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

        $user = $this->createNewUser(1);

        $product = Product::factory()->create();

        $response = $this->actingAs($user)->delete('/products/' . $product->id);

        $response->assertStatus(302);

        $this->assertDatabaseCount('products', 0);

        $this->assertDatabaseMissing('products', $product->toArray());
    }
}
