<?php

namespace App\Repositories;

use App\Interfaces\ProductInterface;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductInterface
{
    public function listing(int $id = null)
    {
        if ($id) {
            return Product::find($id);
        }

        return Product::withTrashed()
            ->get();
    }

    public function activeProducts()
    {
        return Product::with('unit')->whereNull('deleted_at')->get();
    }

    public function store(Request $request, int $id = null)
    {
        try {
            DB::beginTransaction();
            $product = $id ? Product::find($id) : new Product();
            $product->name = $request->name;
            $product->unit_id_fk = $request->unit;
            $product->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function status(int $id)
    {
        $product = Product::where('id', $id)
            ->withTrashed()
            ->first();
        if ($product) {
            if ($product->deleted_at == null) {
                $product->destroy($id);
                return true;
            } else {
                $product->deleted_at = null;
                $product->save();
                return true;
            }
        } else {
            return false;
        }
    }
}
