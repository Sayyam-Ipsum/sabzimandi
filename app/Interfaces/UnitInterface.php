<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface UnitInterface
{
    public function listing($id = null);

    public function activeUnits();

    public function store(Request $request, $id = null);

    public function status($id);
}
