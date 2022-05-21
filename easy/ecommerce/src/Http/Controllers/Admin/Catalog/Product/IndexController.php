<?php

namespace Easy\Ecommerce\Http\Controllers\Admin\Catalog\Product;

use Easy\Ecommerce\Contracts\Catalog\ProductServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class IndexController extends Controller
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
        return Inertia::render('Catalog/Product/Index', [
            'products'=> $this->productService->getList()
        ]);
    }
}
