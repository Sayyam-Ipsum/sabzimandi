<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'super admin')->first();
        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@sabzimandi.com';
        $user->phone = '03053609490';
        $user->address = 'sadiqabad';
        $user->role_id_fk = $role->id;
        $user->password = password_hash('admin1122', PASSWORD_DEFAULT);
        $user->save();
        $user->assignRole($role->name);
    }
}
