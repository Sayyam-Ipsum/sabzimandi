<?php

namespace App\Repositories;

use App\Interfaces\UnitInterface;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UnitRepository implements UnitInterface
{
    public function listing(int $id = null)
    {
        if ($id) {
            return Unit::find($id);
        }

        return Unit::withTrashed()
            ->get();
    }

    public function activeUnits()
    {
        return Unit::whereNull('deleted_at')->get();
    }

    public function store(Request $request, int $id = null)
    {
        try {
            DB::beginTransaction();
            $unit = $id ? Unit::find($id) : new Unit();
            $unit->name = $request->name;
            $unit->slug = Str::slug($request->name);
            $unit->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function status(int $id)
    {
        $unit = Unit::where('id', $id)
            ->withTrashed()
            ->first();
        if ($unit) {
            if ($unit->deleted_at == null) {
                $unit->destroy($id);
                return true;
            } else {
                $unit->deleted_at = null;
                $unit->save();
                return true;
            }
        } else {
            return false;
        }
    }
}
