<?php

namespace Tests\Feature\Validations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\CreateUser;
use Tests\TestCase;

class ProductValidationTest extends TestCase
{
    use RefreshDatabase;
    use CreateUser;

    public function test_product_name_field_is_required(): void
    {
        $user = $this->createNewUser(1);

        $product = [
            'name' => ''
        ];

        $response = $this->actingAs($user)->post('/products', $product);

        $response->assertStatus(302);

        $response->assertSessionHasErrors(['name' => 'El nombre del producto es obligatorio']);
    }

    public function test_product_name_field_is_string(): void
    {
        $user = $this->createNewUser(1);

        $product = [
            'name' => ''
        ];

        $response = $this->actingAs($user)->post('/products', $product);

        $response->assertStatus(302);

        $response->assertSessionHasErrors(['name']);
    }


    public function test_product_price_field_is_numeric(): void
    {
        $user = $this->createNewUser(1);

        $product = [
            'price' => 'hola'
        ];

        $response = $this->actingAs($user)->post('/products', $product);

        $response->assertStatus(302);

        $response->assertSessionHasErrors(['price' => 'El precio debe ser numerico']);
    }
}
