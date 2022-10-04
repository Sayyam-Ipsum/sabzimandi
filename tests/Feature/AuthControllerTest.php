<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AuthControllerTest extends TestCase
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
        $token = DB::table('password_resets')->pluck('token')->first();
        $response = $this->get('/reset/'.$token);
        $response->assertStatus(200);

    }

    public function test_reset_page_invalid_token()
    {
        $token = 'skjdhskjdhksjhedkwnedmsndnsd';
        $response = $this->get('/reset/'.$token);
        $response->assertStatus(302);
    }

    public function test_login()
    {
        $response = $this->post('/login', [
                '_token' => csrf_token(),
                'email' => 'admin@sabzimandi.com',
                'password' => 'admin123'
            ]);

        $response->assertStatus(302);
        $response->assertRedirect('/dashboard');
    }

    public function test_login_validation_failed()
    {
        $response = $this->post('/login', [
            '_token' => csrf_token(),
            'email' => 'admin.com',
            'password' => '1122'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors();
    }

    public function test_login_wrong_credentials()
    {
        $response = $this->post('/login', [
            '_token' => csrf_token(),
            'email' => 'admin@sabzimandi.com',
            'password' => 'admin12324356'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_forgot_password()
    {
        $response = $this->post('/forgot', [
            '_token' => csrf_token(),
            'email' => 'admin@sabzimandi.com'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/forgot');
    }

    public function test_forgot_password_validation_failed()
    {
        $response = $this->post('/forgot', [
            '_token' => csrf_token(),
            'email' => 'admin.com'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/forgot');
        $response->assertSessionHasErrors();
    }

    public function test_forgot_password_user_not_found()
    {
        $response = $this->post('/forgot', [
            '_token' => csrf_token(),
            'email' => 'adm@sabzimandi.com'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/forgot');
    }

//    public function test_forgot_password_mail_not_sent()
//    {
//        $response = $this->post('/forgot', [
//            '_token' => csrf_token(),
//            'email' => 'admin@sabzimandi.com'
//        ]);
//
//        $response->assertRedirect('/forgot');
//    }

    public function test_reset_password_validation_failed()
    {
        $response = $this->post('/reset', [
            '_token' => csrf_token(),
            'password' => 'admin',
            'confirm_password' => 'admin',
            'user_id' => 1,
            'reset_token' => 'test',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/reset/test');
    }

    public function test_reset_password()
    {
        $token = DB::table('password_resets')->pluck('token')->first();
        $response = $this->post('/reset', [
            '_token' => csrf_token(),
            'password' => 'admin123',
            'confirm_password' => 'admin123',
            'user_id' => 7,
            'reset_token' => $token,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_dashoard_page()
    {
        $user = User::find(7);
        $this->actingAs($user);
        $response = $this->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_logout()
    {
        $response = $this->get('/logout');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_dashboard_page_without_authentication()
    {
        $response = $this->get('/dashboard');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_system_down()
    {
        $response = $this->get('/down');

        $response->assertStatus(200);
    }

    public function test_system_up()
    {
        $response = $this->get('/up');

        $response->assertStatus(200);
    }

    public function test_system_optimize()
    {
        $response = $this->get('/optimize');

        $response->assertStatus(200);
    }
}
