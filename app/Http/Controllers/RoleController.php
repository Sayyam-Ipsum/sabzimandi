<?php

namespace App\Http\Controllers;

use App\Interfaces\RoleInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Js;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    use ResponseTrait;

    protected RoleInterface $roleInterface;

    public function __construct(RoleInterface $roleInterface)
    {
        $this->roleInterface = $roleInterface;
    }

    public function index(Request $request): JsonResponse|View
    {
        if ($request->ajax()) {
            $roles = $this->roleInterface->listing();
            return DataTables::of($roles)
                ->addColumn('name', function ($roles) {
                    return $roles->name;
                })
                ->addColumn('actions', function ($roles) {
                    $action = '';
                    if ($roles->deleted_at == null) {
                        $action .= '<button class="btn btn-sm btn-edit btn-secondary mr-1" data-id="' . $roles->id . '">
                            <i class="fa fa-pencil-alt"></i></button>';
                        $action .= '<button class="btn btn-sm btn-info mr-1 btn-permissions" data-id="' . $roles->id . '"><i class="fa fa-universal-access mr-1"></i>Permissions</button>';
                        $action .= '<a class="btn btn-sm btn-status btn-danger" data-id="' . $roles->id . '"><i class="fas fa-lock"></i></a>';
                    } else {
                        $action .= '<a class="btn btn-sm btn-status btn-success" data-id="' . $roles->id . '"><i class="fas fa-lock-open"></i></a>';
                    }
                    return $action;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('roles.listing');
    }

    public function create($id = null): JsonResponse
    {
        if ($id) {
            $role = $this->roleInterface->listing($id);

            return $this->modalResponse('Edit Role', 'roles.form', ['role' => $role]);
        }

        return $this->modalResponse('Create Role', 'roles.form');
    }

    public function store(Request $request, int $id = null): RedirectResponse
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name' . ($id ? ",$id" : ''),
        ]);

        if ($validate->fails()) {
            return redirect('/roles')->withErrors($validate);
        }

        if ($this->roleInterface->store($request, $id)) {
            return redirect('/roles')->with('success', 'Operation Successful');
        }

        return redirect('/roles')->with('error', 'Internal Server Error');
    }

    public function status(int $id): JsonResponse
    {
        if ($this->roleInterface->status($id)) {
            return $this->jsonResponse(1, 'Status Changed');
        }

        return $this->jsonResponse(0, 'Role Not Found!');
    }

    public function rolePermissionsListing(int $id): JsonResponse
    {
        $role = $this->roleInterface->listing($id);
        $permissions = $this->roleInterface->rolePermissionsListing($id);

        return $this->modalResponse(
            'Permissions',
            'roles.permissions',
            ['permissions' => $permissions, 'role' => $role]
        );
    }

    public function managePermissions(Request $request): JsonResponse
    {
        $validate = Validator::make($request->all(), [
            'role_id' => 'required',
            'permission_id' => 'required'
        ]);

        if ($validate->fails()) {
            return $this->jsonResponse(0, 'Validation Error');
        }

        return $this->roleInterface->managePermissions($request);
    }
}
