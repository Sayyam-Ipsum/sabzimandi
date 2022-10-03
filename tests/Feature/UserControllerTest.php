<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    public function test_login_page()
    {
        $response = $this->get('/login');

        $response->assertViewIs('auth.login');
    }

    public function test_forgot_page()
    {
        $response = $this->get('/forgot');

        $response->assertViewIs('auth.forgot');
    }

    public function test_reset_page()
    {
        $user = User::find(7);
        $this->actingAs($user);
        $token = DB::table('password_resets')->pluck('token')->first();
        $response = $this->get('/reset/'.$token);
        $response->assertStatus(200);

    }

    public function test_login()
    {
        $response = $this->post('/login', [
                '_token' => csrf_token(),
                'email' => 'admin@sabzimandi.com',
                'password' => 'admin1122'
            ]);

        $response->assertStatus(302);
    }

    public function test_forgot_password()
    {
        $response = $this->post('/forgot', [
            '_token' => csrf_token(),
            'email' => 'admin@sabzimandi.com'
        ]);

        $response->assertRedirect();
    }

    public function test_reset_password()
    {

    }
}
