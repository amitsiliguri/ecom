<?php

namespace Easy\Ecommerce\Http\Controllers\Admin\Catalog\Product\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Easy\Ecommerce\Contracts\Catalog\Product\InventoryServiceInterface;

class DestroyController extends Controller
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
     * @param int $id
     * @return RedirectResponse
     */
    public function __invoke(int $id): RedirectResponse
    {
        $deletedInventory= $this->inventoryService->delete($id);
        $message = $deletedInventory->title . ' deleted successfully.';
        return redirect()->route('admin.catalog.product.inventory.index')->with('success', $message);
    }
}
