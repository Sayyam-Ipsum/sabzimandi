<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductInterface;
use App\Interfaces\SaleInterface;
use App\Interfaces\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SaleController extends Controller
{
    protected $saleInterface;
    protected $userInterface;
    protected $productInterface;

    public function __construct(
        SaleInterface $saleInterface,
        UserInterface $userInterface,
        ProductInterface $productInterface
    ) {
        $this->saleInterface = $saleInterface;
        $this->userInterface = $userInterface;
        $this->productInterface = $productInterface;
    }

    public function pos()
    {
        $customers = $this->userInterface->activeCustomer();
        $products = $this->productInterface->activeProducts();
        return view('pos.index', compact(['customers', 'products']));
    }

    public function sell(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'customer_id' => 'required',
            'products' => 'required',
            'total' => 'required'
        ]);

        if (!$validate->fails()) {
            $is_sale = $this->saleInterface->sell($request);
            if ($is_sale) {
                $res['success'] = 1;
                $res['message'] = 'Operation Successful';
            } else {
                $res['success'] = 2;
                $res['message'] = 'Internal Server Error';
            }
        } else {
            $res['success'] = 3;
            $res['message'] = $validate->errors();
        }

        return response()->json($res);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $sales = $this->saleInterface->listing();
            return DataTables::of($sales)
                ->addColumn('date', function ($sale) {
                    return showDateTime(@$sale->created_at);
                })
                ->addColumn('customer', function ($sale) {
                    return @$sale->customer->name;
                })
                ->addColumn('phone', function ($sale) {
                    return @$sale->customer->phone ? @$sale->user->phone : 'N/A';
                })
                ->addColumn('total', function ($sale) {
                    return 'Rs. '.@$sale->total;
                })
                ->addColumn('actions', function ($sale) {
                    $action = '';
                    if (@$sale->deleted_at == null) {
                        $action .= '<button class="btn btn-sm btn-view btn-info mr-1" data-id="' . @$sale->id . '">
                            <i class="fa fa-eye"></i></button>';
                    }

                    return $action;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('sales.listing');
    }

    public function todaySales(Request $request)
    {
        if ($request->ajax()) {
            $sales = $this->saleInterface->todaySale();
            return DataTables::of($sales)
                ->addColumn('id', function ($sale) {
                    return @$sale->id;
                })
                ->addColumn('customer', function ($sale) {
                    return @$sale->customer->name;
                })
                ->addColumn('phone', function ($sale) {
                    return @$sale->customer->phone ? @$sale->user->phone : 'N/A';
                })
                ->addColumn('total', function ($sale) {
                    return 'Rs. '.@$sale->total;
                })
                ->addColumn('actions', function ($sale) {
                    $action = '';
                    if (@$sale->deleted_at == null) {
                        $action .= '<button class="btn btn-sm btn-view btn-info mr-1" data-id="' . @$sale->id . '">
                            <i class="fa fa-eye"></i></button>';
                    }

                    return $action;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('sales.today');
    }

    public function show($id)
    {
        $sale = $this->saleInterface->listing($id);
        $res['title'] = 'Sale Details';
        $res['html'] = view('sales.view', compact(['sale']))->render();

        return response()->json($res);
    }

    public function customerSales(Request $request)
    {
        if ($request->get('customer')) {
            $id = $request->get('customer');
            $sales = $this->saleInterface->customerSales($id);
            $res['title'] = 'Customer Sales';
            $res['html'] = view('sales.customer-sales', compact(['sales']))->render();

            return response()->json($res);
        }
    }
}
