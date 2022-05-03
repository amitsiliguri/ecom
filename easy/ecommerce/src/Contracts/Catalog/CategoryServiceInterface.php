<?php

declare(strict_types=1);

namespace Easy\Ecommerce\Contracts\Catalog;

use Easy\Ecommerce\Model\Catalog\Category as CategoryModel;

/**
 * @package Easy\Ecommerce
 * @namespace Easy\Ecommerce\Contracts\Catalog\Category
 * @CategoryServiceInterface
 */
interface CategoryServiceInterface
{
    /**
     * Banner path
     */
    public const BANNER_PATH = 'catalog/category/banner';

    /**
     * Meta Image Path
     */
    public const META_IMAGE_PATH = 'catalog/category/meta_image';

    /**
     * @param array $inputs
     * @return CategoryModel
     */
    public function store(array $inputs): CategoryModel;

    /**
     * @return array
     */
    public function getReorderedCategory(): array;

    /**
     * @param mixed $tree
     * @param int $parentId
     * @return void
     */
    public function saveReorder(mixed $tree, int $parentId = 0): void;

    /**
     * @param int $id
     * @return CategoryModel
     */
    public function getById(int $id): CategoryModel;

    /**
     * @param array $inputs
     * @param int $id
     * @return CategoryModel
     */
    public function update(array $inputs, int $id): CategoryModel;

    /**
     * @param int $id
     * @return CategoryModel
     */
    public function delete(int $id): CategoryModel;
}
