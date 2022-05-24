<?php

namespace Easy\Ecommerce\Http\Controllers\Admin\Catalog\Product\Simple;

use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Easy\Ecommerce\Http\Requests\Admin\Catalog\Product\type\SimpleFormRequest;

class StoreController extends Controller
{
    /**
     * @param SimpleFormRequest $request
     * @return RedirectResponse
     */
    public function __invoke(SimpleFormRequest $request): RedirectResponse
    {
        return redirect()
            ->route('admin.catalog.product.index')
            ->with('success', 'Product created successfully');
    }
}
