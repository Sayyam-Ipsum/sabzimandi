<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductInterface;
use App\Interfaces\SaleInterface;
use App\Interfaces\UserInterface;
use Illuminate\Http\Request;

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
}
