<?php

namespace Easy\Ecommerce\Contracts\Catalog\Product;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use  Easy\Ecommerce\Model\Catalog\Product\Inventory as InventoryModel;
use Illuminate\Database\Eloquent\Collection;

interface InventoryServiceInterface
{
    /**
     * @var array
     */
    public const INVENTORY_MAIN_TABLE = [
        'id',
        'status',
        'title',
        'created_at',
        'updated_at'
    ];

    /**
     * @param bool $all
     * @param int $paginate
     * @param string $sortBy
     * @param string $direction
     * @param array $select
     * @return LengthAwarePaginator
     */
    public function getList(
        bool $isPaginated = true,
        int $paginate = 10,
        string $sortBy = 'id',
        string $direction = 'DESC',
        array $select = self::INVENTORY_MAIN_TABLE
    )  : LengthAwarePaginator| Collection ;

    /**
     * @param array $inputs
     * @return InventoryModel
     */
    public function store(array $inputs): InventoryModel;

    /**
     * @param array $inputs
     * @param int $id
     * @return InventoryModel
     */
    public function update(array $inputs, int $id): InventoryModel;

    /**
     * @param int $id
     * @return InventoryModel
     */
    public function getById(int $id): InventoryModel;

    /**
     * @param int $id
     * @return InventoryModel
     */
    public function delete(int $id): InventoryModel;
}
