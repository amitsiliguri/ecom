<?php

namespace Easy\Ecommerce\Http\Controllers\Admin\Catalog\Product\Inventory;

use Easy\Ecommerce\Contracts\Catalog\Product\InventoryServiceInterface;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class EditController extends Controller
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
     * @param int $id
     * @return Response
     */
    public function __invoke(int $id): Response
    {
        return Inertia::render('Catalog/Product/Inventory/Edit', [
            'inventories'=> $this->inventoryService->adminGridDisplay(),
            'inventory'=> $this->inventoryService->getById($id)
        ]);
    }
}
