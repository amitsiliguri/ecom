<?php

namespace Easy\Ecommerce\Http\Controllers\Admin\Catalog\Product\Inventory;

use Easy\Ecommerce\Contracts\Catalog\CategoryServiceInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Controllers\Controller;

class EditController extends Controller
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
     * @param int $id
     * @return Response
     */
    public function __invoke(int $id): Response
    {
        return Inertia::render('Catalog/Category/Update', [
                'categories' => $this->categoryService->getReorderedCategory(),
                'category' => $this->categoryService->getById($id)
            ]
        );
    }
}
