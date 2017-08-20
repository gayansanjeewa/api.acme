<?php

namespace Product\Repositories;

use App\Product;
use Product\Repositories\Contracts\ProductInterface;

class ProductRepository implements ProductInterface
{
    public function all()
    {
        $products = Product::all();

        return response()->json(compact('products'));
    }
}
