<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface RoleInterface
{
    public function listing($id = null);

    public function activeRoles();

    public function store(Request $request, $id = null);

    public function status($id);

    public function rolePermissionsListing($id);

    public function managePermissions(Request $request);
}
