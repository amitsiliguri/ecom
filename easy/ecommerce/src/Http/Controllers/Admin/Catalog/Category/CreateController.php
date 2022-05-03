<?php

namespace Easy\Ecommerce\Http\Controllers\Admin\Catalog\Category;

use Easy\Ecommerce\Contracts\Catalog\CategoryServiceInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Controllers\Controller;

class CreateController extends Controller
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
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Catalog/Category/Create', [
            'categories'=> $this->categoryService->getReorderedCategory()
        ]);
    }
}
