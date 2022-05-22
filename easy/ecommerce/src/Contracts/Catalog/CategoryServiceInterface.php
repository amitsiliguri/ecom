<?php

declare(strict_types=1);

namespace Easy\Ecommerce\Contracts\Catalog;

use Easy\Ecommerce\Model\Catalog\Category as CategoryModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * @package Easy\Ecommerce
 * @namespace Easy\Ecommerce\Contracts\Catalog\Category
 * @CategoryServiceInterface
 */
interface CategoryServiceInterface
{

    /**
     * @var array
     */
    public const CATALOG_CATEGORY_MAIN_TABLE = [
        'status',
        'title',
        'slug',
        'description',
        'banner',
        'meta_title',
        'meta_description',
        'meta_image',
        'parent_id',
        'sort_order'
    ];

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

    /**
     * @param bool $isPaginated
     * @param array $select
     * @param array $conditions
     * @param int $paginate
     * @param string $sortBy
     * @param string $direction
     * @return LengthAwarePaginator|Collection
     */
    public function getList(
        bool $isPaginated = true,
        array $select = self::CATALOG_CATEGORY_MAIN_TABLE,
        array $conditions  = [],
        int $paginate = 10,
        string $sortBy = 'id',
        string $direction = 'DESC'
    ) : LengthAwarePaginator| Collection;
}
