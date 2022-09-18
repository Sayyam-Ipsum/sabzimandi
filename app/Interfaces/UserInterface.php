<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

/**
 *
 */
interface UserInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function listing($id = null);

    /**
     * @return mixed
     */
    public function customers();

    /**
     * @return mixed
     */
    public function activeUsers();

    /**
     * @return mixed
     */
    public function activeCustomer();

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function store(Request $request, $id = null);

    /**
     * @param $id
     * @return mixed
     */
    public function status($id);
}
