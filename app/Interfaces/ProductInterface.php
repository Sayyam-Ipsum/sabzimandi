<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ProductInterface
{
    public function listing(int $id = null);

    public function store(Request $request, int $id = null);

    public function status(int $id);

    public function activeProducts();
}
