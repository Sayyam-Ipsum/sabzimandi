<?php

namespace App\Http\Controllers;

use App\Interfaces\UnitInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class UnitController extends Controller
{
    use ResponseTrait;

    protected $unitInterface;

    public function __construct(UnitInterface $unitInterface)
    {
        $this->unitInterface = $unitInterface;
    }

    public function index(Request $request)
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

    public function create($id = null)
    {
        if ($id) {
            $unit = $this->unitInterface->listing($id);

            return $this->modalResponse('Edit Unit', 'units.form', ['unit' => $unit]);
        }

        return $this->modalResponse('Create Unit', 'units.form');
    }

    public function store(Request $request, $id = null)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name' . ($id ? ",$id" : ''),
        ]);

        if (!$validate->fails()) {
            $is_store = $this->unitInterface->store($request, $id);
            if ($is_store) {
                return redirect('/units')->with('success', 'Operation Successful');
            } else {
                return redirect('/units')->with('error', 'Internal Server Error');
            }
        } else {
            return redirect('/units')->withErrors($validate);
        }
    }

    public function status($id)
    {
        $is_change = $this->unitInterface->status($id);
        if ($is_change) {
            return $this->jsonResponse(1, 'Status Changed');
        } else {
            return $this->jsonResponse(0, 'Unit Not Found!');
        }
    }
}
