<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface RoleInterface
{
    public function listing(int $id = null);

    public function activeRoles();

    public function store(Request $request, int $id = null);

    public function status(int $id);

    public function rolePermissionsListing(int $id);

    public function managePermissions(Request $request);
}
