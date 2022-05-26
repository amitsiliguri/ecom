<?php

declare(strict_types=1);

namespace Easy\Ecommerce;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Easy\Ecommerce\Contracts\Catalog\CategoryServiceInterface;
use Easy\Ecommerce\Service\Catalog\CategoryService;
use Easy\Ecommerce\Contracts\FileUploadInterface;
use Easy\Ecommerce\Service\FileUpload;
use Easy\Ecommerce\Contracts\Catalog\Category\TreeInterface;
use Easy\Ecommerce\Service\Catalog\Category\Tree;
use Easy\Ecommerce\Contracts\Catalog\ProductServiceInterface;
use Easy\Ecommerce\Service\Catalog\ProductService;
use Easy\Ecommerce\Contracts\Catalog\Product\InventoryServiceInterface;
use Easy\Ecommerce\Service\Catalog\Product\InventoryService;
use Easy\Ecommerce\Contracts\User\Customer\GroupInterface;
use Easy\Ecommerce\Service\User\Customer\Group;
use Easy\Ecommerce\Contracts\Catalog\Product\SimpleProductServiceInterface;
use Easy\Ecommerce\Service\Catalog\Product\SimpleProductService;

/**
 * @package Easy\Ecommerce
 * @EcommerceServiceProvider
 */
class EcommerceServiceProvider extends ServiceProvider
{

    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(FileUploadInterface::class, FileUpload::class);
        $this->app->singleton(TreeInterface::class, Tree::class);
        $this->app->singleton(CategoryServiceInterface::class, CategoryService::class);
        $this->app->singleton(InventoryServiceInterface::class, InventoryService::class);
        $this->app->singleton(ProductServiceInterface::class, ProductService::class);
        $this->app->singleton(GroupInterface::class, Group::class);
        $this->app->singleton(SimpleProductServiceInterface::class, SimpleProductService::class);
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'ecommerce');
        Blade::componentNamespace('Easy\\Ecommerce\\View\\Components', 'ecommerce');
        $this->loadRoutesFrom(__DIR__.'/routes/ecommerce.php');
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../stubs/resources/js' => resource_path('js'),
                __DIR__.'/../stubs/database/migrations' => database_path('migrations'),
                __DIR__.'/../stubs/routes' => base_path('routes')
            ], 'ecommerce');
        }
    }
}
