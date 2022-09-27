<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface UserInterface
{
    public function listing($id = null);

    public function customers();

    public function activeUsers();

    public function activeCustomer();

    public function store(Request $request, $id = null);

    public function status($id);
}
