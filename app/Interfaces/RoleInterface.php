<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

/**
 *
 */
interface RoleInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function listing($id = null);

    /**
     * @return mixed
     */
    public function activeRoles();

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

    /**
     * @param $id
     * @return mixed
     */
    public function rolePermissionsListing($id);

    /**
     * @param Request $request
     * @return mixed
     */
    public function managePermissions(Request $request);
}
