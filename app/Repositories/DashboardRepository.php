<?php

namespace App\Repositories;

use App\Interfaces\DashboardInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardRepository implements DashboardInterface
{
    public function storeProfile(Request $request): bool
    {
        try {
            DB::beginTransaction();
            $user = $request->id ? User::find($request->id) : new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
