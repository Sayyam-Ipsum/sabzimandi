<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $user = User::find(7);
        $this->actingAs($user);
    }

    public function test_profile_page()
    {
        $response = $this->get('/profile');

        $response->assertStatus(200);
    }

    public function test_setting_page()
    {
        $response = $this->get('/setting');

        $response->assertStatus(200);
    }

    public function test_profile_store_validation_error()
    {
        $response = $this->post('/profile', [
            'id' => 7,
            'name' => 'Super Admin',
            'email' => 'admin.com',
            'phone' => '03053609490'
        ]);

        $response->assertStatus(302);
    }

    public function test_profile_store()
    {
        $response = $this->post('/profile', [
            'id' => 7,
            'name' => 'Super Admin',
            'email' => 'admin@sabzimandi.com',
            'phone' => '03053609490'
        ]);

        $response->assertStatus(302);
    }

    public function test_profile_store_failed()
    {
        $str = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries";

        $response = $this->post('/profile', [
            'id' => 7,
            'name' => $str,
            'email' => 'admin@sabzimandi.com',
            'phone' => '03053609490'
        ]);

        $response->assertStatus(302);
    }
}
