<?php

use Illuminate\Support\Facades\Route;

use Easy\Ecommerce\Http\Controllers\Admin\{
    Catalog\Product\IndexController as ProductIndexController,
    Catalog\Product\Simple\UpdateController as ProductSimpleUpdateController,
    Catalog\Product\Simple\StoreController as ProductSimpleStoreController,
    Catalog\Product\Simple\EditController as ProductSimpleEditController,
    Catalog\Product\Simple\DestroyController as ProductSimpleDestroyController,
    Catalog\Product\Simple\CreateController as ProductSimpleCreateController,
    Catalog\Product\Inventory\IndexController as InventoryIndexController,
    Catalog\Product\Inventory\StoreController as InventoryStoreController,
    Catalog\Product\Inventory\EditController as InventoryEditController,
    Catalog\Product\Inventory\UpdateController as InventoryUpdateController,
    Catalog\Product\Inventory\DestroyController as InventoryDestroyController,
    Catalog\Category\UpdateController as CategoryUpdateController,
    Catalog\Category\StoreController as CategoryStoreController,
    Catalog\Category\EditController as CategoryEditController,
    Catalog\Category\CreateController as CategoryCreateController,
    Catalog\Category\Tree\ReorderController as CategoryTreeUpdateController,
    Catalog\Category\DestroyController as CategoryDestroyController,
    Customer\CreateController as CustomerCreateController,
    Customer\EditController as CustomerEditController,
    Customer\IndexController as CustomerIndexController,
    Customer\StoreController as CustomerStoreController,
    Customer\UpdateController as CustomerUpdateController,
    Customer\Group\CreateController as CustomerGroupCreateController,
    Customer\Group\EditController as CustomerGroupEditController,
    Customer\Group\IndexController as CustomerGroupIndexController,
    Customer\Group\StoreController as CustomerGroupStoreController,
    Customer\Group\UpdateController as CustomerGroupUpdateController,
    Marketing\CartDiscount\IndexController as CartDiscountIndexController,
    Marketing\CartDiscount\CreateController as CartDiscountCreateController,
    Marketing\CartDiscount\StoreController as CartDiscountStoreController,
    Marketing\CartDiscount\EditController as CartDiscountEditController,
    Marketing\CartDiscount\UpdateController as CartDiscountUpdateController,
    Marketing\CartDiscount\DestroyController as CartDiscountDestroyController,
    Marketing\CategoryDiscount\IndexController as CategoryDiscountIndexController,
    Marketing\CategoryDiscount\CreateController as CategoryDiscountCreateController,
    Marketing\CategoryDiscount\StoreController as CategoryDiscountStoreController,
    Marketing\CategoryDiscount\EditController as CategoryDiscountEditController,
    Marketing\CategoryDiscount\UpdateController as CategoryDiscountUpdateController,
    Marketing\CategoryDiscount\DestroyController as CategoryDiscountDestroyController,
    Sales\Order\EditController as SalesOrderEditController,
    Sales\Order\IndexController as SalesOrderIndexController,
    Sales\Order\UpdateController as SalesOrderUpdateController,
    Sales\Invoice\IndexController as SalesInvoiceIndexController,
    Sales\Invoice\CreateController as SalesInvoiceCreateController,
    Sales\Invoice\StoreController as SalesInvoiceStoreController,
    Sales\Invoice\EditController as SalesInvoiceEditController,
    Sales\Invoice\UpdateController as SalesInvoiceUpdateController,
    Sales\Cancel\CreateController as SalesCancelCreateController,
    Sales\Invoice\IndexController as SalesCancelIndexController,
    Sales\Invoice\StoreController as SalesCancelStoreController,
    Sales\Return\IndexController as SalesReturnIndexController,
    Sales\Return\EditController as SalesReturnEditController,
    Sales\Return\UpdateController as SalesReturnUpdateController
};

Route::prefix('admin')->name('admin.')->middleware(['web','auth:admin', 'admin.verified'])->group(function () {
    Route::prefix('catalog')->name('catalog.')->group(function () {
        Route::prefix('category')->name('category.')->group(function () {
            Route::get('/create', [CategoryCreateController::class, '__invoke'])->name('create');
            Route::get('/edit/{id}', [CategoryEditController::class, '__invoke'])->name('edit');
            Route::post('/store', [CategoryStoreController::class, '__invoke'])->name('store');
            Route::put('/update/{id}', [CategoryUpdateController::class, '__invoke'])->name('update');
            Route::delete('/delete/{id}', [CategoryDestroyController::class, '__invoke'])->name('delete');
            Route::prefix('tree')->name('tree.')->group(function () {
                Route::post('/reorder', [CategoryTreeUpdateController::class, '__invoke'])->name('reorder');
            });
        });
        Route::prefix('product')->name('product.')->group(function () {
            Route::get('/', [ProductIndexController::class, '__invoke'])->name('index');
            Route::prefix('inventory')->name('inventory.')->group(function () {
                Route::get('/', [InventoryIndexController::class, '__invoke'])->name('index');
                Route::post('store', [InventoryStoreController::class, '__invoke'])->name('store');
                Route::get('edit/{id}', [InventoryEditController::class, '__invoke'])->name('edit');
                Route::put('update/{id}', [InventoryUpdateController::class, '__invoke'])->name('update');
                Route::delete('delete/{id}', [InventoryDestroyController::class, '__invoke'])->name('delete');
            });
            Route::prefix('simple')->name('simple.')->group(function () {
                Route::get('/create', [ProductSimpleCreateController::class, '__invoke'])->name('create');
                Route::post('/store', [ProductSimpleStoreController::class, '__invoke'])->name('store');
                Route::get('/edit/{id}', [ProductSimpleEditController::class, '__invoke'])->name('edit');
                Route::put('/update/{id}', [ProductSimpleUpdateController::class, '__invoke'])->name('update');
                Route::delete('/delete/{id}', [ProductSimpleDestroyController::class, '__invoke'])->name('delete');
            });
        });
    });
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::prefix('group')->name('group.')->group(function () {
            Route::get('/', [CustomerGroupIndexController::class, '__invoke'])->name('index');
            Route::get('/create', [CustomerGroupCreateController::class, '__invoke'])->name('create');
            Route::get('/edit/{id}', [CustomerGroupEditController::class, '__invoke'])->name('edit');
            Route::post('/store', [CustomerGroupStoreController::class, '__invoke'])->name('store');
            Route::put('/update/{id}', [CustomerGroupUpdateController::class, '__invoke'])->name('update');
        });
        Route::get('/', [CustomerIndexController::class, '__invoke'])->name('index');
        Route::get('/create', [CustomerCreateController::class, '__invoke'])->name('create');
        Route::get('/edit/{id}', [CustomerEditController::class, '__invoke'])->name('edit');
        Route::post('/store', [CustomerStoreController::class, '__invoke'])->name('store');
        Route::put('/update/{id}', [CustomerUpdateController::class, '__invoke'])->name('update');
    });
    Route::prefix('marketing')->name('marketing.')->group(function () {
        Route::prefix('discount')->name('marketing.')->group(function () {
            Route::prefix('category')->name('category.')->group(function () {
                Route::get('/', [CategoryDiscountIndexController::class, '__invoke'])->name('index');
                Route::get('/create', [CategoryDiscountCreateController::class, '__invoke'])->name('create');
                Route::get('/edit/{id}', [CategoryDiscountEditController::class, '__invoke'])->name('edit');
                Route::post('/store', [CategoryDiscountStoreController::class, '__invoke'])->name('store');
                Route::put('/update/{id}', [CategoryDiscountUpdateController::class, '__invoke'])->name('update');
                Route::delete('/delete/{id}', [CategoryDiscountDestroyController::class, '__invoke'])->name('delete');
            });
            Route::prefix('cart')->name('cart.')->group(function () {
                Route::get('/', [CartDiscountIndexController::class, '__invoke'])->name('index');
                Route::get('/create', [CartDiscountCreateController::class, '__invoke'])->name('create');
                Route::get('/edit/{id}', [CartDiscountEditController::class, '__invoke'])->name('edit');
                Route::post('/store', [CartDiscountStoreController::class, '__invoke'])->name('store');
                Route::put('/update/{id}', [CartDiscountUpdateController::class, '__invoke'])->name('update');
                Route::delete('/delete/{id}', [CartDiscountDestroyController::class, '__invoke'])->name('delete');
            });
        });
    });
    Route::prefix('sales')->name('sales.')->group(function () {
        Route::prefix('order')->name('order.')->group(function () {
            Route::get('/', [SalesOrderEditController::class, '__invoke'])->name('index');
            Route::get('/edit/{id}', [SalesOrderIndexController::class, '__invoke'])->name('edit');
            Route::put('/update/{id}', [SalesOrderUpdateController::class, '__invoke'])->name('update');
        });
        Route::prefix('invoice')->name('invoice.')->group(function () {
            Route::get('/', [SalesInvoiceIndexController::class, '__invoke'])->name('index');
            Route::get('/create', [SalesInvoiceCreateController::class, '__invoke'])->name('create');
            Route::post('/store', [SalesInvoiceStoreController::class, '__invoke'])->name('store');
            Route::get('/edit/{id}', [SalesInvoiceEditController::class, '__invoke'])->name('edit');
            Route::put('/update/{id}', [SalesInvoiceUpdateController::class, '__invoke'])->name('update');
        });
        Route::prefix('cancel')->name('cancel.')->group(function () {
            Route::get('/', [SalesCancelIndexController::class, '__invoke'])->name('index');
            Route::get('/create', [SalesCancelCreateController::class, '__invoke'])->name('create');
            Route::post('/store', [SalesCancelStoreController::class, '__invoke'])->name('store');
        });
        Route::prefix('return')->name('return.')->group(function () {
            Route::get('/', [SalesReturnIndexController::class, '__invoke'])->name('index');
            Route::get('/edit/{id}', [SalesReturnEditController::class, '__invoke'])->name('edit');
            Route::post('/update/{id}', [SalesReturnUpdateController::class, '__invoke'])->name('update');
        });
    });
});
