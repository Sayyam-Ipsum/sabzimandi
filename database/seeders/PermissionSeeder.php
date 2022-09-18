<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'PageAccess.Users',
            'PageAccess.Products',
            'PageAccess.Roles',
            'PageAccess.Profile',
            'PageAccess.Orders',
            'PageAccess.Reports'
        ];

        foreach ($permissions as $permission) {
            $perm = new Permission();
            $perm->name = $permission;
            $perm->guard_name = 'web';
            $perm->save();
        }
    }
}
