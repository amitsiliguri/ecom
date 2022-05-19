<?php

namespace Easy\Ecommerce\Http\Controllers\Admin\Customer\Group;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Easy\Ecommerce\Contracts\User\Customer\GroupInterface;
use Inertia\Inertia;
use Inertia\Response;

class EditController extends Controller
{
    /**
     * @var GroupInterface
     */
    private GroupInterface $groupInterface;

    /**
     * @param GroupInterface $groupInterface
     */
    public function __construct(GroupInterface $groupInterface)
    {
        $this->groupInterface = $groupInterface;
    }

    /**
     * @param int $id
     * @return Response
     */
    public function __invoke(int $id): Response
    {
        return Inertia::render('Customer/Group/Edit', [
            'customer'=> [
                'group' =>  $this->groupInterface->getById($id)
            ]
        ]);
    }
}
