<?php

namespace App\Http\Controllers;

use App\Interfaces\RoleInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

/**
 *
 */
class RoleController extends Controller
{
    /**
     * @var RoleInterface
     */
    protected $roleInterface;

    /**
     * @param RoleInterface $roleInterface
     */
    public function __construct(RoleInterface $roleInterface)
    {
        $this->roleInterface = $roleInterface;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index(Request $request)
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

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function create($id = null)
    {
        if ($id) {
            $role = $this->roleInterface->listing($id);
            $res['title'] = 'Edit Role';
            $res['html'] = view('roles.form', compact(['role']))->render();
        } else {
            $res['title'] = 'Create Role';
            $res['html'] = view('roles.form')->render();
        }

        return response()->json($res);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, $id = null)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name' . ($id ? ",$id" : ''),
        ]);

        if (!$validate->fails()) {
            $is_store = $this->roleInterface->store($request, $id);
            if ($is_store) {
                return redirect('/roles')->with('success', 'Operation Successful');
            } else {
                return redirect('/roles')->with('error', 'Internal Server Error');
            }
        } else {
            return redirect('/roles')->withErrors($validate);
        }

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function status($id)
    {
        $is_change = $this->roleInterface->status($id);
        if ($is_change) {
            $res['success'] = 1;
            $res['message'] = 'Status Changed';
        } else {
            $res['success'] = 0;
            $res['message'] = 'Role Not Found!';
        }

        return response()->json($res);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function rolePermissionsListing($id)
    {
        $role = $this->roleInterface->listing($id);
        $permissions = $this->roleInterface->rolePermissionsListing($id);
        $res['title'] = 'Permissions';
        $res['html'] = view('roles.permissions', compact(['permissions', 'role']))->render();

        return response()->json($res);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function managePermissions(Request $request)
    {
        return $this->roleInterface->managePermissions($request);
    }
}
