<?php

namespace Product\Repositories;

use App\Product;
use Product\Repositories\Contracts\ProductInterface;

class ProductRepository implements ProductInterface
{
    public function all($params)
    {
        $productBuilder = new Product();

        if (!empty($params['q'])) {
            $productBuilder = $productBuilder->q($params['q']);
        }

        if (!empty($params['display']) && $params['display'] === 'published') {
            $productBuilder = $productBuilder->published();
        }
        
        $products = $productBuilder->get();

        return response()->json(compact('products'));
    }
}
