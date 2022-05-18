<?php

declare(strict_types=1);

namespace Easy\Ecommerce\Http\Controllers\Frontend;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @package Easy\Ecommerce
 * @namespace Easy\Ecommerce\Http\Controllers\Frontend
 * @FrontController
 */
class FrontController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function __invoke(Request $request): View|Factory|Application
    {
        // return view('ecommerce::pages.front');
        return view('welcome');
    }
}
