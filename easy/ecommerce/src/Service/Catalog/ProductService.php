<?php

declare(strict_types=1);

namespace Easy\Ecommerce\Service\Catalog;

use Easy\Ecommerce\Contracts\Catalog\Category\TreeInterface;
use Easy\Ecommerce\Contracts\Catalog\ProductServiceInterface;
use Easy\Ecommerce\Contracts\FileUploadInterface;
use Easy\Ecommerce\Model\Catalog\Category as CategoryModel;
use Easy\Ecommerce\Model\Catalog\Product as ProductModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @namespace Easy\Ecommerce\Service\Catalog
 * @ProductService
 */
class ProductService implements ProductServiceInterface
{
    /**
     * @var TreeInterface
     */
    protected TreeInterface $tree;

    /**
     * @var FileUploadInterface
     */
    protected FileUploadInterface $fileUpload;

    /**
     * @var CategoryModel
     */
    protected CategoryModel $categoryModel;

    /**
     * @var ProductModel
     */
    protected ProductModel $productModel;

    /**
     * @param TreeInterface $tree
     * @param FileUploadInterface $fileUpload
     * @param CategoryModel $categoryModel
     * @param ProductModel $productModel
     */
    public function __construct(
        TreeInterface       $tree,
        FileUploadInterface $fileUpload,
        CategoryModel       $categoryModel,
        ProductModel        $productModel
    )
    {
        $this->tree = $tree;
        $this->fileUpload = $fileUpload;
        $this->categoryModel = $categoryModel;
        $this->productModel = $productModel;
    }

    /**
     * @inheritdoc
     */
    public function getList(
        bool $isPaginated = true,
        int    $paginate = 10,
        string $sortBy = 'id',
        string $direction = 'DESC',
        array  $select = self::PORDUCT_MAIN_TABLE,
    ): LengthAwarePaginator
    {
        return $this->productModel::with(
            [
                "price" => fn($q) => $q->select(['id', 'base_price', 'special_price', 'offer_start', 'offer_end', 'product_id']),
                "images" => fn($q) => $q->where('type', '=', 'small')
            ])
            ->orderBy($sortBy, $direction)
            ->select($select)
            ->paginate($paginate);
    }

    /**
     * @inheritdoc
     */
    public function getById(int $id): Builder|Collection|Model
    {
        return $this->productModel::with([
            'price' => fn($q) => $q->select(['id', 'base_price', 'special_price', 'offer_start', 'offer_end', 'product_id']),
            'tierPrice' => fn($q) => $q->select(['id', 'quantity', 'special_price', 'offer_start', 'offer_end', 'product_id', 'customer_group_id']),
            'images' => fn($q) => $q->select(['id', 'image', 'type', 'alt_name', 'product_id']),
            'stocks' => fn($q) => $q->select(['quantity','reserved_quantity','product_id','inventory_id']),
            'categories' => fn($q) => $q->select(['catalog_categories.id', 'catalog_categories.status', 'catalog_categories.title', 'catalog_categories.slug'])
        ])->select(self::PORDUCT_MAIN_TABLE)->findOrFail($id);
    }
}
