<?php

namespace App\Repositories;

use App\Interfaces\ProductInterface;
use App\Models\Product;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductInterface
{
    public function listing(int $id = null): Arrayable|Collection
    {
        if ($id) {
            return Product::find($id);
        }

        return Product::withTrashed()
            ->get();
    }

    public function activeProducts(): Collection
    {
        return Product::with('unit')->whereNull('deleted_at')->get();
    }

    public function store(Request $request, int $id = null): bool
    {
        $stored = true;

        try {
            DB::beginTransaction();
            $product = $id ? Product::find($id) : new Product();
            $product->name = $request->name;
            $product->unit_id_fk = $request->unit;
            $product->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $stored = false;
        }

        return $stored;
    }

    public function status(int $id): bool
    {
        $status = true;

        $product = Product::where('id', $id)
            ->withTrashed()
            ->first();
        if ($product) {
            if ($product->deleted_at == null) {
                $product->destroy($id);
            }

            $product->deleted_at = null;
            $product->save();
        } else {
            $status = false;
        }

        return $status;
    }
}
