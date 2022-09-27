<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface UserInterface
{
    public function listing(int $id = null);

    public function customers();

    public function activeUsers();

    public function activeCustomer();

    public function store(Request $request, int $id = null);

    public function status(int $id);
}
