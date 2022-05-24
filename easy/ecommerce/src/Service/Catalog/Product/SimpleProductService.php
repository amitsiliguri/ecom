<?php

namespace Easy\Ecommerce\Service\Catalog\Product;

use Easy\Ecommerce\Contracts\Catalog\Product\SimpleProductServiceInterface;
use Easy\Ecommerce\Model\Catalog\Product as ProductModel;

class SimpleProductService implements SimpleProductServiceInterface
{

    /**
     * @inheritDoc
     */
    public function store(array $inputs): ProductModel
    {
        // TODO: Implement store() method.
    }

    /**
     * @inheritDoc
     */
    public function update(array $inputs, int $id): ProductModel
    {
        // TODO: Implement update() method.
    }
}
