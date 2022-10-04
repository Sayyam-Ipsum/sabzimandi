<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $user = User::find(7);
        $this->actingAs($user);
    }

    public function test_users_page()
    {
        $response = $this->get('/users');

        $response->assertStatus(200);
        $response->assertViewIs('users.listing');
    }

    public function test_users_listing()
    {
        $response = $this->get('/users', ['HTTP_X-Requested-With' => 'XMLHttpRequest'] );

        $response->assertStatus(200);
    }

    public function test_create_user_modal()
    {
        $response = $this->get('/users/create?customer=0');

        $response->assertStatus(200);
    }

    public function test_edit_user_modal()
    {
        $response = $this->get('/users/edit/7?customer=0');

        $response->assertStatus(200);
    }

    public function test_store_user_validation_failed()
    {
        $response = $this->post('/users/store', [
            'name' => 'test',
            'email' => 'test.com',
            'role_id' => 2
        ]);

        $response->assertStatus(302);
    }

    public function test_store_user()
    {
        $str = Str::random(6);
        $response = $this->post('/users/store', [
            'name' => $str,
            'email' => $str.'@gmail.com',
            'role_id' => 2
        ]);

        $response->assertStatus(302);
    }

    public function test_update_user()
    {
        $user = User::get()->last();
        $str = Str::random(6);
        $response = $this->post('/users/store/'.$user->id, [
            'name' => $str,
            'email' => $str.'@gmail.com',
            'role_id' => 2
        ]);

        $response->assertStatus(302);
    }

    public function test_change_user_status()
    {
        $user = User::get()->last();
        $response = $this->get('/users/status/'.$user->id);

        $response->assertStatus(200);
    }

    public function test_change_user_status_user_not_found()
    {
        $response = $this->get('/users/status/0');

        $response->assertStatus(200);
    }

    public function test_customers_page()
    {
        $response = $this->get('/customers');

        $response->assertStatus(200);
        $response->assertViewIs('users.customers');
    }

    public function test_customers_listing()
    {
        $response = $this->get('/customers', ['HTTP_X-Requested-With' => 'XMLHttpRequest'] );

        $response->assertStatus(200);
    }

    public function test_customer_details()
    {
        $customer = User::where('role_id_fk', customerRoleId())->whereNull('deleted_at')->get()->last();
        $response = $this->get('/customers/'.$customer->id);

        $response->assertStatus(200);
    }
}
