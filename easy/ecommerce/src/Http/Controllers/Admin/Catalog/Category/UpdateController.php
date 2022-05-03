<?php

namespace Easy\Ecommerce\Http\Controllers\Admin\Catalog\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Easy\Ecommerce\Http\Requests\Admin\Catalog\Category\FormRequest;
use Easy\Ecommerce\Contracts\Catalog\CategoryServiceInterface;

class UpdateController extends Controller
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
     * @param int $id
     * @return RedirectResponse
     */
    public function __invoke(FormRequest $request, int $id): RedirectResponse
    {
        $category = $this->categoryService->update($request->validated(), $id);
        $message = $category->title . ' update successfully.';
        return redirect()->route('admin.catalog.category.create')->with('success', $message);
    }
}
