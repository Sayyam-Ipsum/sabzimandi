<?php

namespace App\Http\Controllers;

use App\Interfaces\RoleInterface;
use App\Interfaces\SaleInterface;
use App\Interfaces\UserInterface;
use App\Models\Role;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use App\Traits\ResponseTrait;

class UserController extends Controller
{
    use ResponseTrait;

    protected UserInterface $userInterface;
    protected RoleInterface $roleInterface;
    protected SaleInterface $saleInterface;

    public function __construct(UserInterface $userInterface, RoleInterface $roleInterface, SaleInterface $saleInterface)
    {
        $this->userInterface = $userInterface;
        $this->roleInterface = $roleInterface;
        $this->saleInterface = $saleInterface;
    }

    public function index(Request $request): JsonResponse|View
    {
        if ($request->ajax()) {
            $users = $this->userInterface->listing();
            return DataTables::of($users)
                ->addColumn('name', function ($users) {
                    return $users->name;
                })
                ->addColumn('email', function ($users) {
                    return $users->email;
                })
                ->addColumn('phone', function ($users) {
                    return $users->phone ? $users->phone : 'N/A';
                })
                ->addColumn('address', function ($users) {
                    return $users->address ? $users->address : 'N/A';
                })
                ->addColumn('role', function ($users) {
                    return $users->role->name;
                })
                ->addColumn('actions', function ($users) {
                    $action = '';
                    if ($users->deleted_at == null) {
                        $action .= '<button class="btn btn-sm btn-edit btn-secondary mr-1" data-id="' . $users->id . '">
                            <i class="fa fa-pencil-alt"></i></button>';
                        $action .= '<a class="btn btn-sm btn-status btn-danger" data-id="' . $users->id . '"><i class="fas fa-user-lock"></i></a>';
                    } else {
                        $action .= '<a class="btn btn-sm btn-status btn-success" data-id="' . $users->id . '"><i class="fas fa-lock-open"></i></a>';
                    }

                    return $action;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('users.listing');
    }

    public function customers(Request $request): JsonResponse|View
    {
        if ($request->ajax()) {
            $customers = $this->userInterface->customers();
            return DataTables::of($customers)
                ->addColumn('name', function ($customers) {
                    return $customers->name;
                })
                ->addColumn('email', function ($customers) {
                    return $customers->email;
                })
                ->addColumn('phone', function ($customers) {
                    return $customers->phone ? $customers->phone : 'N/A';
                })
                ->addColumn('address', function ($customers) {
                    return $customers->address ? $customers->address : 'N/A';
                })
                ->addColumn('actions', function ($customers) {
                    $action = '';
                    if ($customers->deleted_at == null) {
                        $action .= '<button class="btn btn-sm btn-edit btn-secondary mr-1" data-id="' . $customers->id . '">
                            <i class="fa fa-pencil-alt"></i></button>';
                        $action .= '<a class="btn btn-sm btn-view btn-primary mr-1" href="/customers/' . $customers->id . '">
                            <i class="fa fa-eye"></i></a>';
                        $action .= '<a class="btn btn-sm btn-status btn-danger mr-1" data-id="' . $customers->id . '"><i class="fas fa-user-lock"></i></a>';
                        $action .= '<a class="btn btn-sm btn-payment btn-dark" data-id="' . $customers->id . '"><i class="fas fa-plus-square mr-1"></i>Payment</a>';
                    } else {
                        $action .= '<a class="btn btn-sm btn-status btn-success" data-id="' . $customers->id . '"><i class="fas fa-lock-open"></i></a>';
                    }

                    return $action;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('users.customers');
    }

    public function create(Request $request, int $id = null): JsonResponse
    {
        $customer = $request->get('customer') == 1 ? 1 : 0;
        $roles = $this->roleInterface->activeRoles();
        if ($id) {
            $user = $this->userInterface->listing($id);

            return $this->modalResponse(
                $customer ? 'Edit Customer' : 'Edit User',
                'users.form',
                ['user' => $user, 'roles' => $roles, 'customer' => $customer]
            );
        }

        return $this->modalResponse(
            $customer ? 'Create Customer' : 'Create User',
            'users.form',
            ['roles' => $roles, 'customer' => $customer]
        );
    }

    public function store(Request $request, int $id = null): RedirectResponse
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:users,name' . ($id ? ",$id" : ''),
            'email' => 'required|email|unique:users,email' . ($id ? ",$id" : ''),
            'role_id' => 'required'
        ]);

        if ($validate->fails()) {
            return redirect('/users')->withErrors($validate);
        }

        if ($this->userInterface->store($request, $id)) {
            if ($request->input('role_id') == customerRoleId()) {
                return redirect('/customers')->with('success', 'Operation Successful');
            }

            return redirect('/users')->with('success', 'Operation Successful');
        }

        return redirect('/users')->with('error', 'Internal Server Error');
    }

    public function status(int $id): JsonResponse
    {
        if ($this->userInterface->status($id)) {
            return $this->jsonResponse(1, 'Status Changed');
        }

        return $this->jsonResponse(0, 'User Not Found!');
    }

    public function customerDetails(int $id)
    {
        $customer = $this->userInterface->listing($id);
        $account = $this->saleInterface->customerLastPayment($id);
        $sales = $this->saleInterface->customerSales($id);

        return view('users.customer-view', compact(['customer', 'account', 'sales']));
    }
}
