<?php

namespace Easy\Ecommerce\Http\Controllers\Admin\Customer\Group;

use App\Http\Controllers\Controller;
use Easy\Ecommerce\Contracts\User\Customer\GroupInterface;
use Illuminate\Http\RedirectResponse;

class DestroyController extends Controller
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
     * @return RedirectResponse
     */
    public function __invoke(int $id): RedirectResponse
    {
        $deletedCustomerGroup = $this->groupInterface->delete($id);
        $message = $deletedCustomerGroup->title . ' deleted successfully.';
        return redirect()->route('admin.customer.group.index')->with('success', $message);
    }
}
