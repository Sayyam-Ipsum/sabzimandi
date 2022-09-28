<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'Super Admin',
            'Salesman',
            'Sale Manager',
            'Customer',
            'Finance Manager',
        ];

        foreach ($roles as $value) {
            $role = new Role();
            $role->name = $value;
            $role->guard_name = 'web';
            $role->save();
        }
    }
}
