<?php

namespace App\Repositories;

use App\Interfaces\RoleInterface;
use App\Models\Permission;
use App\Models\Role;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoleRepository implements RoleInterface
{
    use ResponseTrait;

    public function listing(int $id = null)
    {
        if ($id) {
            return Role::find($id);
        }

        return Role::withTrashed()
            ->get();
    }

    public function activeRoles()
    {
        return Role::whereNull('deleted_at')
            ->get();
    }

    public function store(Request $request, int $id = null)
    {
        try {
            DB::beginTransaction();
            $role = $id ? Role::find($id) : new Role();
            $role->name = $request->name;
            $role->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function status(int $id)
    {
        $role = Role::where('id', $id)
            ->withTrashed()
            ->first();
        if ($role) {
            if ($role->deleted_at == null) {
                $role->destroy($id);
                return true;
            } else {
                $role->deleted_at = null;
                $role->save();
                return true;
            }
        } else {
            return false;
        }
    }

    public function rolePermissionsListing(int $id): Arrayable
    {
        $sortedPermissions = [];
        $permissions = Permission::all();
        $rolePermissions = DB::table('permissions')
            ->where('role_has_permissions.role_id', $id)
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->select(
                'permissions.id as permission_id',
                'permissions.name as permission_name',
                'role_has_permissions.role_id'
            )
            ->get();

        if (is_iterable($rolePermissions)) {
            foreach ($rolePermissions as $e) {
                $sortedPermissions[$e->permission_id] = $e;
            }
        }

        if (is_iterable($permissions)) {
            foreach ($permissions as $permission) {
                $permission['status'] = false;
                if (array_key_exists($permission->id, $sortedPermissions)) {
                    $permission['status'] = true;
                }
            }
        }

        return is_iterable($permissions) ? $permissions : [];
    }

    public function managePermissions(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $checkPermission = DB::table('role_has_permissions')
                ->where('role_id', $request->role_id)
                ->where('permission_id', $request->permission_id)
                ->first();
            $role = Role::findById($request->role_id);
            $permission = Permission::findById($request->permission_id);

            if ($checkPermission) {
                $role->revokePermissionTo($permission);
                DB::commit();
                return $this->jsonResponse(1, 'Permission Disabled');
            }

            $role->givePermissionTo($permission);
            DB::commit();
            return $this->jsonResponse(1, 'Permission Granted');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonResponse(0, 'Internal Server Error');
        }
    }
}
