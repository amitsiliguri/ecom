<?php

namespace Easy\Ecommerce\Contracts\Catalog\Product;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
     * @param int $paginate
     * @param array $select
     * @param string $sortBy
     * @param string $direction
     * @return LengthAwarePaginator
     */
    public function adminGridDisplay(
        int $paginate = 10,
        string $sortBy = 'id',
        string $direction = 'DESC',
        array $select = self::INVENTORY_MAIN_TABLE
    ) : LengthAwarePaginator ;
}
