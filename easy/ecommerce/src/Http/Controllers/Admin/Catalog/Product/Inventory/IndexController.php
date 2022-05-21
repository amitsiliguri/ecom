<?php

namespace Easy\Ecommerce\Http\Controllers\Admin\Catalog\Product\Inventory;

use Easy\Ecommerce\Contracts\Catalog\Product\InventoryServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

/**
 * @package Easy\Ecommerce
 * @namespace Easy\Ecommerce\Http\Controllers\Admin\Catalog\Product\Inventory
 * @IndexController
 */
class IndexController extends Controller
{
    /**
     * @var InventoryServiceInterface
     */
    private InventoryServiceInterface $inventoryService;

    /**
     * @param InventoryServiceInterface $inventoryService
     */
    public function __construct(InventoryServiceInterface $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Catalog/Product/Inventory/Index', [
            'inventories'=> $this->inventoryService->getList()
        ]);
    }
}
