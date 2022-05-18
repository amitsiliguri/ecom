<?php

declare(strict_types=1);

namespace Easy\Ecommerce\Http\Controllers\Admin\Customer\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Easy\Ecommerce\Http\Requests\Admin\Customer\GroupFromRequest;
use Easy\Ecommerce\Contracts\User\Customer\GroupInterface;

class StoreController extends Controller
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
     * @param GroupFromRequest $request
     * @return RedirectResponse
     */
    public function __invoke(GroupFromRequest $request): RedirectResponse
    {
        $this->groupInterface->store($request->validated());
        return redirect()
            ->route('admin.customer.group.index')
            ->with('success', 'Group created successfully');
    }
}
