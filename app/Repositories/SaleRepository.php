<?php

namespace App\Repositories;

use App\Interfaces\SaleInterface;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SaleRepository implements SaleInterface
{
    public function sell(Request $request)
    {
        try {
            DB::beginTransaction();
            $invoice = new Invoice();
            $invoice->user_id_fk = $request->customer_id;
            $invoice->total = $request->total;
            $invoice->save();
            if ($invoice) {
                foreach ($request->products as $product) {
                    $item = new InvoiceItem();
                    $item->invoice_id_fk = $invoice->id;
                    $item->product_id_fk = $product['id'];
                    $item->quantity = $product['qty'];
                    $item->amount = $product['total'];
                    $item->save();
                }
                DB::commit();
                return true;
            } else {
                DB::rollBack();
                return false;
            }

        } catch (\Exception $e) {
            return false;
        }
    }

    public function todaySale()
    {
        return Invoice::whereDate('created_at', Carbon::today())->get();
    }

    public function saleDetails($id)
    {
        return Invoice::find($id);
    }
}
