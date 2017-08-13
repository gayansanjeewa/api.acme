<?php

namespace Product;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Product\Repositories\Contracts\ProductInterface;
use Product\Repositories\ProductRepository;

class ProductServiceProvider extends RouteServiceProvider
{
    public function register()
    {
        $this->app->bind(
            ProductInterface::class,
            ProductRepository::class
        );

        parent::register();
    }
}
