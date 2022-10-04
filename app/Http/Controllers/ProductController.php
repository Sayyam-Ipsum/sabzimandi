<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductInterface;
use App\Interfaces\UnitInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    use ResponseTrait;

    protected ProductInterface $productInterface;
    protected UnitInterface $unitInterface;

    public function __construct(ProductInterface $productInterface, UnitInterface $unitInterface)
    {
        $this->productInterface = $productInterface;
        $this->unitInterface = $unitInterface;
    }

    public function index(Request $request): JsonResponse|View
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

    public function create($id = null): JsonResponse
    {
        $units = $this->unitInterface->activeUnits();
        if ($id) {
            $product = $this->productInterface->listing($id);

            return $this->modalResponse('Edit Product', 'products.form', ['product' => $product, 'units' => $units]);
        }

        return $this->modalResponse('Create Product', 'products.form', ['units' => $units]);
    }

    public function store(Request $request, int $id = null): RedirectResponse
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name' . ($id ? ",$id" : ''),
            'unit' => 'required'
        ]);

        if ($validate->fails()) {
            return redirect('/products')->withErrors($validate);
        }

        if ($this->productInterface->store($request, $id)) {
            return redirect('/products')->with('success', 'Operation Successful');
        }

        return redirect('/products')->with('error', 'Internal Server Error');
    }

    public function status($id): JsonResponse
    {
        if ($this->productInterface->status($id)) {
            return $this->jsonResponse(1, 'Status Changed');
        }

        return $this->jsonResponse(0, 'Product Not Found!');
    }
}
