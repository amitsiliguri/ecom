<?php

namespace Easy\Ecommerce\Http\Controllers\Admin\Customer\Group;

use Easy\Ecommerce\Contracts\User\Customer\GroupInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class IndexController extends Controller
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
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Customer/Group/Index', [
            'customer'=> [
                'groups' => $this->groupInterface->getList()
            ]
        ]);
    }
}
