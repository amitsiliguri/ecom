<?php

namespace Easy\Ecommerce\Http\Controllers\Admin\Customer\Group;

use Easy\Ecommerce\Contracts\User\Customer\GroupInterface;
use Easy\Ecommerce\Http\Requests\Admin\Customer\GroupFromRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class UpdateController extends Controller
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
     * @param GroupFromRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function __invoke(GroupFromRequest $request, int $id): RedirectResponse
    {
        $group = $this->groupInterface->update($request->validated(),$id);
        $message = $group->title . ' update successfully.';
        return redirect()->route('admin.customer.group.index')->with('success', $message);
    }
}
