<?php

namespace Easy\Ecommerce\Http\Controllers\Admin\Catalog\Product\Simple;

use Easy\Ecommerce\Contracts\Catalog\ProductServiceInterface;
use Easy\Ecommerce\Contracts\Catalog\Product\InventoryServiceInterface;
use Easy\Ecommerce\Contracts\User\Customer\GroupInterface as GroupServiceInterface;
use Easy\Ecommerce\Contracts\Catalog\CategoryServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class CreateController extends Controller
{
    /**
     * @var InventoryServiceInterface
     */
    protected InventoryServiceInterface $inventoryService;

    /**
     * @var GroupServiceInterface
     */
    protected GroupServiceInterface $groupService;

    /**
     * @var CategoryServiceInterface
     */
    protected CategoryServiceInterface $categoryService;

    /**
     * @param InventoryServiceInterface $inventoryService
     * @param GroupServiceInterface $groupService
     * @param CategoryServiceInterface $categoryService
     */
    public function __construct(
        InventoryServiceInterface $inventoryService,
        GroupServiceInterface $groupService,
        CategoryServiceInterface $categoryService
    ) {
        $this->inventoryService = $inventoryService;
        $this->groupService = $groupService;
        $this->categoryService = $categoryService;
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response|RedirectResponse
     */
    public function __invoke(Request $request): Response|RedirectResponse
    {
        $customerGroups = $this->groupService->getList(false, ['id','status', 'title']);
        $categories = $this->categoryService->getList(false, ['id', 'title', 'parent_id', 'sort_order'], [], 0, 'sort_order', 'ASC');
        $inventories = $this->inventoryService->getList(false);

        if (count($customerGroups) && count($categories) && count($inventories)){
            return Inertia::render('Catalog/Product/Simple/Create', [
                'user' => [
                    'customer' => [
                        'groups' => $customerGroups
                    ],
                ],
                'catalog' => [
                    'categories' => $categories,
                    'product' => [
                        'inventories' => $inventories
                    ]
                ]
            ]);
        } else {
            return redirect()
                ->route('admin.catalog.product.index')
                ->with('error', 'Please make sure you have created categories, customer groups and inventories first.');
        }
    }
}
