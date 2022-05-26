<?php

namespace Easy\Ecommerce\Http\Controllers\Admin\Catalog\Product\Simple;

use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Easy\Ecommerce\Http\Requests\Admin\Catalog\Product\type\SimpleFormRequest;
use Easy\Ecommerce\Contracts\Catalog\Product\SimpleProductServiceInterface;

class StoreController extends Controller
{
    /**
     * @var SimpleProductServiceInterface
     */
    protected SimpleProductServiceInterface $simpleProductService;

    /**
     * @param SimpleProductServiceInterface $simpleProductService
     */
    public function __construct(SimpleProductServiceInterface $simpleProductService)
    {
        $this->simpleProductService = $simpleProductService;
    }

    /**
     * @param SimpleFormRequest $request
     * @return RedirectResponse
     */
    public function __invoke(SimpleFormRequest $request): RedirectResponse
    {
        $this->simpleProductService->store($request->validated());
        return redirect()
            ->route('admin.catalog.product.index')
            ->with('success', 'Product created successfully');
    }
}
