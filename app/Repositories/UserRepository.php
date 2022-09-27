<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Jobs\SendEmailJob;
use App\Models\ModelHasRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserInterface
{
    public function listing(int $id = null)
    {
        if ($id) {
            return User::find($id);
        }

        return User::whereNot('role_id_fk', customerRoleId())->withTrashed()->get();
    }

    public function customers()
    {
        return User::where('role_id_fk', customerRoleId())->withTrashed()->get();
    }

    public function activeUsers()
    {
        return User::whereNot('role_id_fk', customerRoleId())->whereNull('deleted_at')->get();
    }

    public function activeCustomer()
    {
        return User::where('role_id_fk', customerRoleId())->whereNull('deleted_at')->get();
    }

    public function store(Request $request, int $id = null)
    {
        try {
            DB::beginTransaction();
            $user = $id ? User::find($id) : new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->role_id_fk = $request->role_id;
            $user->password = password_hash('admin1122', PASSWORD_DEFAULT);
            $user->save();
            $role = Role::findById($request->role_id);
            if (!isset($id)) {
                $user->assignRole($role['name']);
                dispatch(new SendEmailJob($user));
            }

            if (isset($id)) {
                $user->syncRoles($role['name']);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function status(int $id)
    {
        $user = User::where('id', $id)
            ->withTrashed()
            ->first();
        if ($user) {
            if ($user->deleted_at == null) {
                $user->destroy($id);
                return true;
            } else {
                $user->deleted_at = null;
                $user->save();
                return true;
            }
        } else {
            return false;
        }
    }
}
