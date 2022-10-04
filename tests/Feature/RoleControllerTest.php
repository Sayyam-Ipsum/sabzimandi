<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class RoleControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $user = User::find(7);
        $this->actingAs($user);
    }

    public function test_roles_page()
    {
        $response = $this->get('/roles');

        $response->assertStatus(200);
        $response->assertViewIs('roles.listing');
    }

    public function test_roles_listing()
    {
        $response = $this->get('/roles', ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
    }

    public function test_create_role_modal()
    {
        $response = $this->get('/roles/create');

        $response->assertStatus(200);
    }

    public function test_edit_role_modal()
    {
        $role = Role::get()
            ->last();
        $response = $this->get('/roles/edit/' . $role->id);

        $response->assertStatus(200);
    }

    public function test_store_role_validation_failed()
    {
        $response = $this->post('/roles/store', [
            'name' => '',
        ]);

        $response->assertStatus(302);
    }

    public function test_store_role_failed()
    {
        $str = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries";
        $response = $this->post('/roles/store', [
            'name' => $str,
        ]);

        $response->assertStatus(302);
    }

    public function test_store_role()
    {
        $str = Str::random(6);
        $response = $this->post('/roles/store', [
            'name' => $str,
        ]);

        $response->assertStatus(302);
    }

    public function test_update_role()
    {
        $role = Role::get()
            ->last();
        $str = Str::random(6);
        $response = $this->post('/roles/store/' . $role->id, [
            'name' => $str,
        ]);

        $response->assertStatus(302);
    }

    public function test_change_role_status()
    {
        $role = Role::get()
            ->last();
        $response = $this->get('/roles/status/' . $role->id);

        $response->assertStatus(200);
    }

    public function test_change_role_status_role_not_found()
    {
        $response = $this->get('/roles/status/0');

        $response->assertStatus(200);
    }

    public function test_role_permissions()
    {
        $role = Role::get()
            ->last();
        $response = $this->get('/roles/permissions/' . $role->id);

        $response->assertStatus(200);
    }

    public function test_manage_role_permission()
    {
        $role = Role::get()
            ->last();
        $permission = Permission::get()
            ->last();

        $response = $this->post('/roles/permissions', [
            'role_id' => $role->id,
            'permission_id' => $permission->id
        ]);

        $response->assertStatus(200);
    }

    public function test_manage_role_permission_validation_failed()
    {
        $response = $this->post('/roles/permissions', [
            'role_id' => '',
            'permission_id' => ''
        ]);

        $response->assertStatus(200);
    }
}
