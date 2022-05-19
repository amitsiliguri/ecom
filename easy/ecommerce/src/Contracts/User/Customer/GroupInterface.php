<?php

declare(strict_types=1);

namespace Easy\Ecommerce\Contracts\User\Customer;

use Easy\Ecommerce\Model\Customer\Group as CustomerGroupModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
        array $select = self::CUSTOMER_GROUP_MAIN_TABLE
    ) : LengthAwarePaginator ;

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
}
