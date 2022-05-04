<?php

declare(strict_types=1);

namespace Easy\Ecommerce\Http\Controllers\Admin\Catalog\Product\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Easy\Ecommerce\Http\Requests\Admin\Catalog\Product\InventoryFormRequest;
use Easy\Ecommerce\Contracts\Catalog\Product\InventoryServiceInterface;

/**
 * @package Easy\Ecommerce
 * @namespace Easy\Ecommerce\Http\Controllers\Admin\Catalog\Category
 * @StoreController
 */
class StoreController extends Controller
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
     * @param InventoryFormRequest $request
     * @return RedirectResponse
     */
    public function __invoke(InventoryFormRequest $request): RedirectResponse
    {
        $this->inventoryService->store($request->validated());
        return redirect()->route('admin.catalog.product.inventory.index')->with('success', 'Inventory created successfully');
    }
}
