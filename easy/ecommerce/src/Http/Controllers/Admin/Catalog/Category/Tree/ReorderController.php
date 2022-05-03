<?php

namespace Easy\Ecommerce\Http\Controllers\Admin\Catalog\Category\Tree;

use Easy\Ecommerce\Contracts\Catalog\CategoryServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReorderController extends Controller
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
     * @param Request $request
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $requestData = $request->all();
        $this->categoryService->saveReorder($requestData['treeList']);
        return redirect()->back()->with('success', 'Category re-order is successful.');
    }
}
