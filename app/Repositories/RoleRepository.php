<?php

namespace App\Repositories;

use App\Interfaces\RoleInterface;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 *
 */
class RoleRepository implements RoleInterface
{
    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function listing($id = null)
    {
        if ($id) {
            return Role::find($id);
        }

        return Role::withTrashed()
            ->get();
    }

    /**
     * @return mixed
     */
    public function activeRoles()
    {
        return Role::whereNull('deleted_at')->get();
    }

    /**
     * @param Request $request
     * @param $id
     * @return bool
     */
    public function store(Request $request, $id = null)
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

    /**
     * @param $id
     * @return bool
     */
    public function status($id)
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

    /**
     * @param $id
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function rolePermissionsListing($id)
    {
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

        if (sizeof($permissions) > 0) {
            foreach ($permissions as $permission) {
                $permission['status'] = false;
                if (sizeof($rolePermissions) > 0) {
                    foreach ($rolePermissions as $rolePermission) {
                        if ($permission->id == $rolePermission->permission_id) {
                            $permission['status'] = true;
                        }
                    }
                }
            }
        }

        return isset($permissions) ? $permissions : [];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function managePermissions(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'role_id' => 'required',
            'permission_id' => 'required'
        ]);

        if (!$validate->fails()) {
            try {
                DB::beginTransaction();
                $checkPermission = DB::table('role_has_permissions')
                    ->where('role_id', $request->role_id)
                    ->where('permission_id', $request->permission_id)
                    ->first();
                $role = Role::findById($request->role_id);
                $permission = Permission::findById($request->permission_id);
                $res['success'] = 1;
                if ($checkPermission) {
                    $role->revokePermissionTo($permission);
                    $res['message'] = 'Permission Disabled';
                } else {
                    $role->givePermissionTo($permission);
                    $res['message'] = 'Permission Granted';
                }
                DB::commit();
                return response()->json($res);
            } catch (\Exception $e) {
                DB::rollBack();
                $res['success'] = 0;
                $res['message'] = 'Internal Server Error';
                return response()->json($res);
            }
        } else {
            $res['success'] = 0;
            $res['message'] = 'Validation Error';
            return response()->json($res);
        }
    }
}
