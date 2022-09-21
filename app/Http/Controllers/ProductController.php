<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductInterface;
use App\Interfaces\UnitInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    protected $productInterface;
    protected $unitInterface;

    public function __construct(ProductInterface $productInterface, UnitInterface $unitInterface)
    {
        $this->productInterface = $productInterface;
        $this->unitInterface = $unitInterface;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = $this->productInterface->listing();
            return DataTables::of($products)
                ->addColumn('name', function ($products) {
                    return $products->name;
                })
                ->addColumn('unit', function ($products) {
                    return $products->unit ? $products->unit->name : 'N/A';
                })
                ->addColumn('actions', function ($products) {
                    $action = '';
                    if ($products->deleted_at == null) {
                        $action .= '<button class="btn btn-sm btn-edit btn-secondary mr-1" data-id="' . $products->id . '">
                            <i class="fa fa-pencil-alt"></i></button>';
                        $action .= '<a class="btn btn-sm btn-status btn-danger" data-id="' . $products->id . '"><i class="fas fa-lock"></i></a>';
                    } else {
                        $action .= '<a class="btn btn-sm btn-status btn-success" data-id="' . $products->id . '"><i class="fas fa-lock-open"></i></a>';
                    }
                    return $action;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('products.listing');
    }

    public function create($id = null)
    {
        $units = $this->unitInterface->activeUnits();
        if ($id) {
            $product = $this->productInterface->listing($id);
            $res['title'] = 'Edit Product';
            $res['html'] = view('products.form', compact(['product', 'units']))->render();
        } else {
            $res['title'] = 'Create Product';
            $res['html'] = view('products.form', compact(['units']))->render();
        }

        return response()->json($res);
    }

    public function store(Request $request, $id = null)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name' . ($id ? ",$id" : ''),
        ]);

        if (!$validate->fails()) {
            $is_store = $this->productInterface->store($request, $id);
            if ($is_store) {
                return redirect('/products')->with('success', 'Operation Successful');
            } else {
                return redirect('/products')->with('error', 'Internal Server Error');
            }
        } else {
            return redirect('/products')->withErrors($validate);
        }
    }

    public function status($id)
    {
        $is_change = $this->productInterface->status($id);
        if ($is_change) {
            $res['success'] = 1;
            $res['message'] = 'Status Changed';
        } else {
            $res['success'] = 0;
            $res['message'] = 'Product Not Found!';
        }

        return response()->json($res);
    }
}
