<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductInterface;
use App\Interfaces\SaleInterface;
use App\Interfaces\UserInterface;
use App\Models\Payment;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class SaleController extends Controller
{
    use ResponseTrait;

    protected SaleInterface $saleInterface;
    protected UserInterface $userInterface;
    protected ProductInterface $productInterface;

    public function __construct(
        SaleInterface $saleInterface,
        UserInterface $userInterface,
        ProductInterface $productInterface
    ) {
        $this->saleInterface = $saleInterface;
        $this->userInterface = $userInterface;
        $this->productInterface = $productInterface;
    }

    public function pos(): View
    {
        $customers = $this->userInterface->activeCustomer();
        $products = $this->productInterface->activeProducts();

        return view('pos.index', compact(['customers', 'products']));
    }

    public function sell(Request $request): JsonResponse
    {
        $validate = Validator::make($request->all(), [
            'customer_id' => 'required',
            'products' => 'required',
            'total' => 'required'
        ]);

        if ($validate->fails()) {
            $res['success'] = 3;
            $res['message'] = $validate->errors();

            return response()->json($res);
        }

        if ($this->saleInterface->sell($request)) {
            return $this->jsonResponse(1, 'Operation Successful');
        }

        return $this->jsonResponse(2, 'Internal Server Error');
    }

    public function list(Request $request): JsonResponse|View
    {
        if ($request->ajax()) {
            $sales = $this->saleInterface->listing();
            return DataTables::of($sales)
                ->addColumn('date', function ($sale) {
                    return @$sale->created_at;
                })
                ->addColumn('customer', function ($sale) {
                    return @$sale->customer->name;
                })
                ->addColumn('phone', function ($sale) {
                    return @$sale->customer->phone ? @$sale->user->phone : 'N/A';
                })
                ->addColumn('total', function ($sale) {
                    return 'Rs. ' . @$sale->total;
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

    public function todaySales(Request $request): JsonResponse|View
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
                    return 'Rs. ' . @$sale->total;
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

    public function show(int $id): JsonResponse
    {
        $sale = $this->saleInterface->listing($id);

        return $this->modalResponse('Sale Details', 'sales.view', ['sale' => $sale]);
    }

    public function customerPaymentModal($customerID): JsonResponse
    {
        $payment = $this->saleInterface->customerLastPayment($customerID);

        return $this->modalResponse('Add Payment', 'users.payment', ['payment' => $payment]);
    }

    public function storePayment(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'payment_id' => 'required',
            'total' => 'required',
            'payable' => 'required'
        ]);

        if ($validate->fails()) {
            return redirect('/customers')->withErrors($validate);
        }

        if ($this->saleInterface->storePayment($request)) {
            return redirect('/customers')->with('success', 'Payment Add Successfully');
        }

        return redirect('/customers')->with('error', 'Internal Server Error');
    }
}
