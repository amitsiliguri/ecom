<?php

namespace Easy\Ecommerce\Contracts\Catalog\Product;

use Easy\Ecommerce\Model\Catalog\Product as ProductModel;

interface SimpleProductServiceInterface
{
    /**
     * @param array $inputs
     * @return void
     */
    public function store(array $inputs): void;

    /**
     * @param array $inputs
     * @param int $id
     * @return ProductModel
     */
    public function update(array $inputs, int $id): ProductModel;
}
