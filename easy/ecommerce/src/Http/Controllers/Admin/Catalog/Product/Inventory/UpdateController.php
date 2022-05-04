<?php

namespace Easy\Ecommerce\Http\Controllers\Admin\Catalog\Product\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Easy\Ecommerce\Http\Requests\Admin\Catalog\Product\InventoryFormRequest;
use Easy\Ecommerce\Contracts\Catalog\Product\InventoryServiceInterface;

class UpdateController extends Controller
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
     * @param int $id
     * @return RedirectResponse
     */
    public function __invoke(InventoryFormRequest $request, int $id): RedirectResponse
    {
        $inventory = $this->inventoryService->update($request->validated(),$id);
        $message = $inventory->title . ' update successfully.';
        return redirect()->route('admin.catalog.product.inventory.index')->with('success', $message);
    }
}
