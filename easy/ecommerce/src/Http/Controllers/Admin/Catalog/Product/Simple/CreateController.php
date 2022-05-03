<?php

namespace Easy\Ecommerce\Http\Controllers\Admin\Catalog\Product\Simple;

use Easy\Ecommerce\Contracts\Catalog\ProductServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class CreateController extends Controller
{

    /**
     * @var ProductServiceInterface
     */
    private ProductServiceInterface $productService;

    /**
     * @param ProductServiceInterface $productService
     */
    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $customerGroups = array(
            array(
                'id' => 1,
                'title' => 'Default Customer Group'
            ),
            array(
                'id' => 2,
                'title' => 'Customer Group 1'
            ),
            array(
                'id' => 3,
                'title' => 'Customer Group 2'
            ),
        );

        $inventories = array(
            array(
                'id' => 1,
                'title' => 'Default inventory very long'
            ),
            array(
                'id' => 2,
                'title' => 'inventory 1'
            ),
            array(
                'id' => 3,
                'title' => 'inventory 2'
            ),
        );

        $categories = array(
            array(
                'id' => 1,
                'title' => 'Default category 1',
                'parent' => 0
            ),
            array(
                'id' => 2,
                'title' => 'category 2',
                'parent' => 1
            ),
            array(
                'id' => 3,
                'title' => 'category 3',
                'parent' => 1
            ),
            array(
                'id' => 4,
                'title' => 'category 2 4',
                'parent' => 2
            ),
            array(
                'id' => 5,
                'title' => 'category 3 5',
                'parent' => 3
            ),
            array(
                'id' => 6,
                'title' => 'category 3 6',
                'parent' => 3
            ),
        );

        return Inertia::render('Catalog/Product/Simple/Create', [
            'product' => $this->productService->adminFormProductData(1),
            'customer_groups' => $customerGroups,
            'inventories' => $inventories,
            'categories' => $categories
        ]);
    }
}
