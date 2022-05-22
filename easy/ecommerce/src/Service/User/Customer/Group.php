<?php

namespace Easy\Ecommerce\Service\User\Customer;

use Easy\Ecommerce\Contracts\User\Customer\GroupInterface;
use Easy\Ecommerce\Model\Customer\Group as CustomerGroupModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

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
    public function getList(
        bool $isPaginated = true,
        array $select = self::CUSTOMER_GROUP_MAIN_TABLE,
        array $conditions  = [],
        int $paginate = 10,
        string $sortBy = 'id',
        string $direction = 'DESC'
    ) : LengthAwarePaginator| Collection {
        $list = $this->customerGroupModel::select($select)->orderBy($sortBy, $direction);
        if (count($conditions)) {
            foreach ($conditions as $condition){
                if (
                    array_key_exists('column',$condition) &&
                    array_key_exists('operator',$condition) &&
                    array_key_exists('value',$condition)
                ) {
                    $list->where($condition['column'],$condition['operator'],$condition['value']);
                }
            }
        }
        if ($isPaginated) {
            return $list->paginate($paginate);
        }
        return $list->get();
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
