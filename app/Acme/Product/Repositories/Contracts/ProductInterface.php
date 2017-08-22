<?php

namespace Product\Repositories\Contracts;

interface ProductInterface
{
    public function all($params);

    public function store($request);
}
