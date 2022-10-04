<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $user = User::find(7);
        $this->actingAs($user);
    }

    public function test_products_page()
    {
        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertViewIs('products.listing');
    }

    public function test_products_listing()
    {
        $response = $this->get('/products', ['HTTP_X-Requested-With' => 'XMLHttpRequest'] );

        $response->assertStatus(200);
    }

    public function test_create_product_modal()
    {
        $response = $this->get('/products/create');

        $response->assertStatus(200);
    }

    public function test_edit_product_modal()
    {
        $response = $this->get('/products/edit/3');

        $response->assertStatus(200);
    }

    public function test_store_product_validation_failed()
    {
        $response = $this->post('/products/store', [
            'name' => '',
            'unit_id_fk' => ''
        ]);

        $response->assertStatus(302);
    }

    public function test_store_product()
    {
        $unit = Unit::get()->last();
        $str = Str::random(6);
        $response = $this->post('/products/store', [
            'name' => $str,
            'unit_id_fk' => $unit->id
        ]);

        $response->assertStatus(302);
    }

    public function test_update_product()
    {
        $product = Product::get()->last();
        $str = Str::random(6);
        $response = $this->post('/products/store/'.$product->id, [
            'name' => $str,
            'unit_id_fk' => $product->unit_id_fk
        ]);

        $response->assertStatus(302);
    }

    public function test_change_product_status()
    {
        $product = Product::get()->last();
        $response = $this->get('/products/status/'.$product->id);

        $response->assertStatus(200);
    }

    public function test_change_product_status_product_not_found()
    {
        $response = $this->get('/products/status/0');

        $response->assertStatus(200);
    }
}
