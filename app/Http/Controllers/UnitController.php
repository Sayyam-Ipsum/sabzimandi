<?php

namespace App\Http\Controllers;

use App\Interfaces\UnitInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Js;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class UnitController extends Controller
{
    use ResponseTrait;

    protected UnitInterface $unitInterface;

    public function __construct(UnitInterface $unitInterface)
    {
        $this->unitInterface = $unitInterface;
    }

    public function index(Request $request): JsonResponse|View
    {
        if ($request->ajax()) {
            $units = $this->unitInterface->listing();
            return DataTables::of($units)
                ->addColumn('name', function ($units) {
                    return $units->name;
                })
                ->addColumn('actions', function ($units) {
                    $action = '';
                    if ($units->deleted_at == null) {
                        $action .= '<button class="btn btn-sm btn-edit btn-secondary mr-1" data-id="' . $units->id . '">
                            <i class="fa fa-pencil-alt"></i></button>';
                        $action .= '<a class="btn btn-sm btn-status btn-danger" data-id="' . $units->id . '"><i class="fas fa-lock"></i></a>';
                    } else {
                        $action .= '<a class="btn btn-sm btn-status btn-success" data-id="' . $units->id . '"><i class="fas fa-lock-open"></i></a>';
                    }
                    return $action;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('units.listing');
    }

    public function create(int $id = null): JsonResponse
    {
        if ($id) {
            $unit = $this->unitInterface->listing($id);

            return $this->modalResponse('Edit Unit', 'units.form', ['unit' => $unit]);
        }

        return $this->modalResponse('Create Unit', 'units.form');
    }

    public function store(Request $request, int $id = null): RedirectResponse
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:units,name' . ($id ? ",$id" : ''),
        ]);

        if ($validate->fails()) {
            return redirect('/units')->withErrors($validate);
        }

        if ($this->unitInterface->store($request, $id)) {
            return redirect('/units')->with('success', 'Operation Successful');
        }

        return redirect('/units')->with('error', 'Internal Server Error');
    }

    public function status(int $id): JsonResponse
    {
        if ($this->unitInterface->status($id)) {
            return $this->jsonResponse(1, 'Status Changed');
        }

        return $this->jsonResponse(0, 'Unit Not Found!');
    }
}
