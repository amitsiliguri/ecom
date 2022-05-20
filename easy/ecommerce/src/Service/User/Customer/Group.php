<?php

namespace Easy\Ecommerce\Service\User\Customer;

use Easy\Ecommerce\Contracts\User\Customer\GroupInterface;
use Easy\Ecommerce\Model\Customer\Group as CustomerGroupModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Group implements GroupInterface
{

    protected CustomerGroupModel $customerGroupModel;

    public function __construct(CustomerGroupModel $customerGroupModel)
    {
        $this->customerGroupModel = $customerGroupModel;
    }

    /**
     * @inheritDoc
     */
    public function adminGridDisplay(int $paginate = 10, string $sortBy = 'id', string $direction = 'DESC', array $select = self::CUSTOMER_GROUP_MAIN_TABLE): LengthAwarePaginator
    {
        return $this->customerGroupModel::select($select)->orderBy($sortBy, $direction)->paginate($paginate);
    }

    /**
     * @inheritDoc
     */
    public function store(array $inputs): CustomerGroupModel
    {
        return $this->customerGroupModel::create([
            'status' => $inputs['status'],
            'title' => $inputs['title']
        ]);
    }

    /**
     * @param int $id
     * @return CustomerGroupModel
     */
    public function getById(int $id): CustomerGroupModel
    {
        return $this->customerGroupModel::findOrFail($id);
    }

    public function update(array $inputs, int $id): CustomerGroupModel
    {
        $this->customerGroupModel::where('id', $id)->update([
            'status' => $inputs['status'],
            'title' => $inputs['title']
        ]);
        return $this->getById( $id);
    }

    public function delete(int $id): CustomerGroupModel
    {
        $customerGroup = $customerGroupTemp = $this->getById($id);
        $customerGroup->delete();
        return $customerGroupTemp;
    }
}
