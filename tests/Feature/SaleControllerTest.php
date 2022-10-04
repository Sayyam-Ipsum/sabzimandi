<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SaleControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $user = User::find(7);
        $this->actingAs($user);
    }

    public function test_sales_page()
    {
        $response = $this->get('/sales');

        $response->assertStatus(200);
    }

    public function test_sales_listing()
    {
        $response = $this->get('/sales', ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
    }

    public function test_today_sales_page()
    {
        $response = $this->get('/sales/today');

        $response->assertStatus(200);
    }

    public function test_today_sales_listing()
    {
        $response = $this->get('/sales/today', ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
    }

    public function test_sale_details()
    {
        $sale = Invoice::get()->last();
        $response = $this->get('/sales/'.$sale->id);

        $response->assertStatus(200);
    }

    public function test_customer_payment_modal()
    {
        $customer = User::where('role_id_fk', customerRoleId())->get()->last();
        $response = $this->get('/sales/payment/'.$customer->id);

        $response->assertStatus(200);
    }

    public function test_store_payment()
    {
        $payment = Payment::get()->last();
        $response = $this->post('/payment', [
            'payment_id' => $payment->id,
            'total' => $payment->total,
            'payable' => 200
        ]);

        $response->assertStatus(302);
    }

    public function test_store_payment_validation_failed()
    {
        $payment = Payment::get()->last();
        $response = $this->post('/payment', [
            'payment_id' => '',
            'total' => '',
            'payable' => ''
        ]);

        $response->assertStatus(302);
    }

    public function test_pos_page()
    {
        $response = $this->get('/pos');

        $response->assertStatus(200);
    }

    public function test_customer_payment_modal_via_pos()
    {
        $customer = User::where('role_id_fk', customerRoleId())->get()->last();
        $response = $this->get('/pos/payment/'.$customer->id);

        $response->assertStatus(200);
    }

    public function test_sell_products_validation_failed()
    {
        $response = $this->post('/pos', [
            'customer_id' => '',
            'products' => '',
            'total' => ''
        ]);

        $response->assertStatus(200);
    }

    public function test_sell_products()
    {
        $customer = User::where('role_id_fk', customerRoleId())->get()->last();
        $products = [
            [
                'id' => 3,
                'name' => 'test-1',
                'qty' => 2,
                'total' => 200
            ],
            [
                'id' => 4,
                'name' => 'test-2',
                'qty' => 3,
                'total' => 300
            ]
        ];
        $response = $this->post('/pos', [
            'customer_id' => $customer->id,
            'products' => $products,
            'total' => 500
        ]);

        $response->assertStatus(200);
    }

    public function test_store_payment_with_remaining_amount_zero()
    {
        $payment = Payment::where('remain', '=', 0)->first();
        $response = $this->post('/payment', [
            'payment_id' => $payment->id,
            'total' => $payment->total,
            'payable' => 200
        ]);

        $response->assertStatus(302);
    }
}
