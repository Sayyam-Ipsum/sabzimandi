<?php

namespace Tests\Feature;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UnitControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $user = User::find(7);
        $this->actingAs($user);
    }

    public function test_units_page()
    {
        $response = $this->get('/units');

        $response->assertStatus(200);
        $response->assertViewIs('units.listing');
    }

    public function test_units_listing()
    {
        $response = $this->get('/units', ['HTTP_X-Requested-With' => 'XMLHttpRequest'] );

        $response->assertStatus(200);
    }

    public function test_create_unit_modal()
    {
        $response = $this->get('/units/create');

        $response->assertStatus(200);
    }

    public function test_edit_unit_modal()
    {
        $response = $this->get('/units/edit/1');

        $response->assertStatus(200);
    }

    public function test_store_unit_validation_failed()
    {
        $response = $this->post('/units/store', [
            'name' => '',
        ]);

        $response->assertStatus(302);
    }

    public function test_store_unit()
    {
        $str = Str::random(6);
        $response = $this->post('/units/store', [
            'name' => $str,
        ]);

        $response->assertStatus(302);
    }

    public function test_update_unit()
    {
        $unit = Unit::get()->last();
        $str = Str::random(6);
        $response = $this->post('/units/store/'.$unit->id, [
            'name' => $str,
        ]);

        $response->assertStatus(302);
    }

    public function test_change_unit_status()
    {
        $unit = Unit::get()->last();
        $response = $this->get('/units/status/'.$unit->id);

        $response->assertStatus(200);
    }

    public function test_change_unit_status_unit_not_found()
    {
        $response = $this->get('/units/status/0');

        $response->assertStatus(200);
    }
}
