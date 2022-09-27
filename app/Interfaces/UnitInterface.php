<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface UnitInterface
{
    public function listing(int $id = null);

    public function activeUnits();

    public function store(Request $request, int $id = null);

    public function status(int $id);
}
