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
        $stored = true;
        try {
            DB::beginTransaction();
            $user = $request->id ? User::find($request->id) : new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->save();
            DB::commit();
        } catch (\Exception $e) {
            $stored = false;
        }

        return $stored;
    }
}
