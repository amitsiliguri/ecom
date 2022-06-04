<?php

namespace Easy\Ecommerce\Http\Controllers\Admin\Catalog\Product\Simple;

use Easy\Ecommerce\Contracts\Catalog\CategoryServiceInterface;
use Easy\Ecommerce\Contracts\Catalog\Product\InventoryServiceInterface;
use Easy\Ecommerce\Contracts\Catalog\ProductServiceInterface;
use Easy\Ecommerce\Contracts\User\Customer\GroupInterface as GroupServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class EditController extends Controller
{
    /**
     * @var ProductServiceInterface
     */
    protected ProductServiceInterface $productService;

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
     * @param ProductServiceInterface $productService
     */
    public function __construct(
        InventoryServiceInterface $inventoryService,
        GroupServiceInterface     $groupService,
        CategoryServiceInterface  $categoryService,
        ProductServiceInterface   $productService
    )
    {
        $this->productService = $productService;
        $this->inventoryService = $inventoryService;
        $this->groupService = $groupService;
        $this->categoryService = $categoryService;
    }

    /**
     * Handle the incoming request.
     *
     * @param int $id
     * @return Response
     */
    public function __invoke(int $id): Response
    {
        return Inertia::render('Catalog/Product/Simple/Edit', [
            'user' => [
                'customer' => [
                    'groups' => $this->groupService->getList(false, ['id', 'status', 'title'], [
                        [
                            'column' => 'status',
                            'operator' => '=',
                            'value' => 1
                        ]
                    ])
                ],
            ],
            'catalog' => [
                'categories' => $this->categoryService->getList(false, ['id', 'title', 'parent_id', 'sort_order'], [], 0, 'sort_order', 'ASC'),
                'product' => [
                    'edit' => $this->productService->getById($id),
                    'inventories' => $this->inventoryService->getList(false)
                ]
            ]
        ]);
    }
}
