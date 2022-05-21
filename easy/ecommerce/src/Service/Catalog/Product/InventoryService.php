<?php

declare(strict_types=1);

namespace Easy\Ecommerce\Service\Catalog\Product;

use Easy\Ecommerce\Contracts\Catalog\Product\InventoryServiceInterface;
use Easy\Ecommerce\Model\Catalog\Product\Inventory as ProductInventoryModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

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
    public function getList(
        bool $isPaginated = true,
        int $paginate = 10,
        string $sortBy = 'id',
        string $direction = 'DESC',
        array $select = self::INVENTORY_MAIN_TABLE,
    )  : LengthAwarePaginator| Collection {
        if ($isPaginated) {
            return $this->productInventoryModel::select($select)->orderBy($sortBy, $direction)->paginate($paginate);
        } else {
            return $this->productInventoryModel::all();
        }
    }

    /**
     * @inheritdoc
     */
    public function store(array $inputs): ProductInventoryModel
    {
        return $this->productInventoryModel::create([
            'status' => $inputs['status'],
            'title' => $inputs['title']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function update(array $inputs, int $id): ProductInventoryModel
    {
        $this->productInventoryModel::where('id', $id)->update([
            'status' => $inputs['status'],
            'title' => $inputs['title']
        ]);
        return $this->getById( $id);
    }

    /**
     * @param int $id
     * @return ProductInventoryModel
     */
    public function getById(int $id): ProductInventoryModel
    {
        return $this->productInventoryModel::findOrFail($id);
    }

    public function delete(int $id): ProductInventoryModel
    {
        $inventory = $inventoryTemp = $this->getById($id);
        $inventory->delete();
        return $inventoryTemp;
    }
}
