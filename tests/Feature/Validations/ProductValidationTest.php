<?php

namespace Tests\Feature\Validations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductValidationTest extends TestCase
{
    public function test_product_name_field_is_required(): void
    {
        $product = [
            'name' => ''
        ];

        $response = $this->post('/products', $product);

        $response->assertStatus(302);

        $response->assertSessionHasErrors(['name' => 'El nombre del producto es obligatorio']);
    }

    public function test_product_name_field_is_string(): void
    {
        $product = [
            'name' => ''
        ];

        $response = $this->post('/products', $product);

        $response->assertStatus(302);

        $response->assertSessionHasErrors(['name']);
    }


    public function test_product_price_field_is_numeric(): void
    {
        $product = [
            'price' => 'hola'
        ];

        $response = $this->post('/products', $product);

        $response->assertStatus(302);

        $response->assertSessionHasErrors(['price' => 'El precio debe ser numerico']);
    }
}
