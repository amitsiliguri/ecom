<?php

namespace Easy\Ecommerce\Http\Controllers\Admin\Catalog\Product\Simple;

use Easy\Ecommerce\Contracts\Catalog\ProductServiceInterface;
use Easy\Ecommerce\Contracts\Catalog\Product\InventoryServiceInterface;
use Easy\Ecommerce\Contracts\User\Customer\GroupInterface as GroupServiceInterface;
use Easy\Ecommerce\Contracts\Catalog\CategoryServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class CreateController extends Controller
{

    /**
     * @var ProductServiceInterface
     */
    private ProductServiceInterface $productService;

    /**
//     * @param ProductServiceInterface $productService
     * @param InventoryServiceInterface $inventoryService
     * @param GroupServiceInterface $groupService
     */
    public function __construct(
//        ProductServiceInterface $productService,
        InventoryServiceInterface $inventoryService,
        GroupServiceInterface $groupService,
        CategoryServiceInterface $categoryService
    ) {
//        $this->productService = $productService;
        $this->inventoryService = $inventoryService;
        $this->groupService = $groupService;
        $this->categoryService = $categoryService;
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Catalog/Product/Simple/Create', [
            'user' => [
                'customer' => [
                    'groups' => $this->groupService->getList(false, ['id','status', 'title'],[
                        [
                            'column' => 'status',
                            'operator' => '=',
                            'value' => 1
                        ]
                    ])
                ],
            ],
            'catalog' => [
                'categories' => $this->categoryService->getReorderedCategory(),
                'product' => [
                    'inventories' => $this->inventoryService->getList(false)
                ]
            ]
        ]);
    }
}
