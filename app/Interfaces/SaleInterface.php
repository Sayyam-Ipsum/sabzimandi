<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface SaleInterface
{
    public function sell(Request $request);

    public function todaySale();

    public function listing($id = null);

    public function customerSales($id);
}
