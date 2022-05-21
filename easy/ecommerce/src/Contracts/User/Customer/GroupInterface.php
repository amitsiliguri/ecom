<?php

declare(strict_types=1);

namespace Easy\Ecommerce\Contracts\User\Customer;

use Easy\Ecommerce\Model\Customer\Group as CustomerGroupModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface GroupInterface
{
    /**
     * @var array
     */
    public const CUSTOMER_GROUP_MAIN_TABLE = [
        'id',
        'status',
        'title',
        'created_at',
        'updated_at'
    ];

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
        array $select = self::CUSTOMER_GROUP_MAIN_TABLE,
        array $conditions  = [],
        int $paginate = 10,
        string $sortBy = 'id',
        string $direction = 'DESC'
    ) : LengthAwarePaginator| Collection;

    /**
     * @param array $inputs
     * @return CustomerGroupModel
     */
    public function store(array $inputs): CustomerGroupModel;

    /**
     * @param int $id
     * @return CustomerGroupModel
     */
    public function getById(int $id): CustomerGroupModel;

    /**
     * @param array $inputs
     * @param int $id
     * @return CustomerGroupModel
     */
    public function update(array $inputs, int $id): CustomerGroupModel;

    /**
     * @param int $id
     * @return CustomerGroupModel
     */
    public function delete(int $id): CustomerGroupModel;
}
