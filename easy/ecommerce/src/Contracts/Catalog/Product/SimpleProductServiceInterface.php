<?php

namespace Easy\Ecommerce\Contracts\Catalog\Product;

use Easy\Ecommerce\Model\Catalog\Product as ProductModel;

interface SimpleProductServiceInterface
{
    /**
     * Meta Image Path
     */
    public const META_IMAGE_PATH = 'catalog/product/simple/meta_image';

    /**
     * Image Path
     */
    public const IMAGE_PATH = 'catalog/product/simple/image';

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
