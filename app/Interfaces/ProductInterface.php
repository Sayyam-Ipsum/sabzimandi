<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ProductInterface
{
    public function listing($id = null);

    public function store(Request $request, $id = null);

    public function status($id);

    public function activeProducts();
}
