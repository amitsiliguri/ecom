<?php

declare(strict_types=1);

namespace Easy\Ecommerce\Http\Controllers\Admin\Catalog\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Easy\Ecommerce\Http\Requests\Admin\Catalog\Category\FormRequest;
use Easy\Ecommerce\Contracts\Catalog\CategoryServiceInterface;

/**
 * @package Easy\Ecommerce
 * @namespace Easy\Ecommerce\Http\Controllers\Admin\Catalog\Category
 * @StoreController
 */
class StoreController extends Controller
{
    /**
     * @var CategoryServiceInterface
     */
    private CategoryServiceInterface $categoryService;

    /**
     * @param CategoryServiceInterface $categoryService
     */
    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Handle the incoming request.
     *
     * @param FormRequest $request
     * @return RedirectResponse
     */
    public function __invoke(FormRequest $request): RedirectResponse
    {
        $this->categoryService->store($request->validated());
        return redirect()->route('admin.catalog.category.create')->with('success', 'Category updated successfully');
    }
}
