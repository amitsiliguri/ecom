<?php

declare(strict_types=1);

namespace Easy\Ecommerce\Contracts\Catalog;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ProductServiceInterface
{
    /**
     * @var array
     */
    public const PORDUCT_MAIN_TABLE = [
        'id',
        'status',
        'sku',
        'title',
        'small_description',
        'description',
        'maintain_stock',
        'slug',
        'meta_title',
        'meta_description',
        'meta_image',
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
        array $select = self::PORDUCT_MAIN_TABLE
    ) : LengthAwarePaginator ;

    /**
     * @param int $id
     * @return Builder|Collection|Model
     */
    public function adminFormProductData(int $id) : Builder|Collection|Model;
}
