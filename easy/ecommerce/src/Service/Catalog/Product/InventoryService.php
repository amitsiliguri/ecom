<?php

declare(strict_types=1);

namespace Easy\Ecommerce\Service\Catalog\Product;

use Easy\Ecommerce\Contracts\Catalog\Product\InventoryServiceInterface;
use Easy\Ecommerce\Model\Catalog\Product\Inventory as ProductInventoryModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * @namespace Easy\Ecommerce\Service\Catalog\Product
 * @InventoryService
 */
class InventoryService implements InventoryServiceInterface
{
    /**
     * @var ProductInventoryModel
     */
    protected ProductInventoryModel $productInventoryModel;

    /**
     * @param ProductInventoryModel $productInventoryModel
     */
    public function __construct(ProductInventoryModel $productInventoryModel) {
        $this->productInventoryModel = $productInventoryModel;
    }

    /**
     * @inheritdoc
     */
    public function adminGridDisplay(
        int $paginate = 10,
        string $sortBy = 'id',
        string $direction = 'DESC',
        array $select = self::INVENTORY_MAIN_TABLE,
    ): LengthAwarePaginator {
        return $this->productInventoryModel::select($select)->orderBy($sortBy, $direction)->paginate($paginate);
    }

}
