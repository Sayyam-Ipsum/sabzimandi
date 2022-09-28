<?php

namespace App\Repositories;

use App\Interfaces\SaleInterface;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SaleRepository implements SaleInterface
{
    public function sell(Request $request): bool
    {
        $stored = true;

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

                $checkCustomerPaymentRecord = $this->customerLastPayment($invoice->user_id_fk);

                $payment = new Payment();
                $payment->customer_id_fk = $invoice->user_id_fk;
                $payment->total = !empty($checkCustomerPaymentRecord) ?
                    !empty($checkCustomerPaymentRecord->receive) ? $checkCustomerPaymentRecord->remain + $invoice->total :
                        $checkCustomerPaymentRecord->total + $invoice->total : $invoice->total;
                $payment->save();
                DB::commit();
            } else {
                DB::rollBack();
                $stored = false;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $stored = false;
        }

        return $stored;
    }

    public function todaySale()
    {
        return Invoice::whereDate('created_at', Carbon::today())
            ->orderBy('id', 'desc')
            ->get();
    }

    public function listing(int $id = null)
    {
        if ($id) {
            return Invoice::find($id);
        }

        return Invoice::orderBy('created_at', 'desc')
            ->get();
    }

    public function customerSales(int $id)
    {
        return Invoice::where('user_id_fk', $id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function customerLastPayment(int $customerId)
    {
        return Payment::where('customer_id_fk', $customerId)
            ->get()
            ->last();
    }

    public function storePayment(Request $request)
    {
        $stored = true;

        try {
            DB::beginTransaction();
            $payment = Payment::find($request->payment_id);
            if ($payment->remain == 0) {
                $payment->receive = $request->payable;
                $payment->remain = $request->total - $request->payable;
                $payment->save();
            } else {
                $newPayment = new Payment();
                $newPayment->customer_id_fk = $payment->customer_id_fk;
                $newPayment->total = $payment->remain;
                $newPayment->receive = $request->payable;
                $newPayment->remain = $payment->remain - $request->payable;
                $newPayment->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $stored = false;
        }

        return $stored;
    }
}
