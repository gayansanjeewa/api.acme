<?php

namespace Product\Repositories;

use App\Events\ProductHasPublished;
use App\Product;
use Carbon\Carbon;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use Product\Constants\ProductStatus;
use Product\Exceptions\UnprocessableProductException;
use Product\Repositories\Contracts\ProductInterface;

class ProductRepository implements ProductInterface
{
    use ValidatesRequests;

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

    public function store($request)
    {
        $data = unwrap($request, STEP1)['product'];

        $validator = Validator::make($data, [
            'name' => 'required',
            'price' => 'required|numeric',
            'publish' => 'nullable|date',
        ]);
        if ($validator->fails()) {
            throw new UnprocessableProductException($validator->errors()->toArray());
        }

        $data['user_id'] = auth()->user()->id;
        $data['published_at'] = $this->publishedAt($data); // TODO: set crone
        $data['status'] = $this->status($data);

        $product = Product::create($data);
        event(new ProductHasPublished($product));
        return response()->json(compact('product'));
    }

    private function publishedAt($data)
    {
        return empty($data['publish']) ? Carbon::now() : Carbon::parse($data['publish']);
    }

    private function status($data)
    {
        if ($data['published_at'] <= Carbon::now()) {
            return ProductStatus::PUBLISH;
        }
        return ProductStatus::PENDING;
    }

    public function publishScheduledProducts()
    {
        try {
            $builder = Product::published()->where('status', ProductStatus::PENDING);
            $products = $builder->get();

            if (!$products->isEmpty()) {
                $builder->update(['status'=>ProductStatus::PUBLISH]);
                $products->each(function ($product) {
                    event(new ProductHasPublished($product));
                });
            }
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
        }
    }
}
