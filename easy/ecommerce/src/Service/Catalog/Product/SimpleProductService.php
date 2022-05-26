<?php

namespace Easy\Ecommerce\Service\Catalog\Product;

use Easy\Ecommerce\Contracts\Catalog\Product\SimpleProductServiceInterface;
use Easy\Ecommerce\Model\Catalog\Product as ProductModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SimpleProductService implements SimpleProductServiceInterface
{

    protected ProductModel $productModel;

    public function __construct(ProductModel $productModel)
    {
        $this->productModel = $productModel;
    }

    /**
     * @inheritDoc
     */
    public function store(array $inputs): void
    {
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/inputs.log'),
        ])->error([
            'message' => $inputs,
        ]);

        DB::beginTransaction();
        try {
            $newProduct = $this->productModel::create([
                'status' => $inputs['status'],
                'sku' => $inputs['sku'],
                'title' => $inputs['title'],
                'small_description' => $inputs['small_description'],
                'description' => $inputs['description'],
                'maintain_stock' => $inputs['maintain_stock'],
                'in_stock' => $inputs['in_stock'],
                'meta_title' => $inputs['meta_title'],
                'meta_description' => $inputs['meta_description'],
                'slug' => $inputs['slug'],
            ]);
            // add tier prices

            if (
                array_key_exists("tier_prices",$inputs) &&
                is_array($inputs['tier_prices']) &&
                count($inputs['tier_prices']) > 0
            ) {
                $newProduct->tierPrice()->createMany($inputs['tier_prices']);
            }
            // add inventories to product


            if (
                array_key_exists("inventories",$inputs) &&
                is_array($inputs['inventories']) &&
                count($inputs['inventories']) > 0
            ) {
                $inventories = $this->stockCollection($inputs['inventories']);
                if (count($inventories) > 0) {
                    $newProduct->stocks()->createMany($inventories);
                }
            }
            $newProduct->categories()->sync($inputs['categories']);
            $newProduct->price()->create($inputs['price']);
//            // add images to product
//            if (
//                array_key_exists("images",$inputs) &&
//                is_array($inputs['images']) &&
//                count($inputs['images']) > 0
//            ) {
//                $this->productModel->images()->createMany(
//                    $this->_catalogProductCommonController->productImages($inputs['images'])
//                );
//            }
//            // add categories to product
            DB::commit();
        } catch (\Exception $e) {
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/product.log'),
            ])->error([
                'message' => $e->getMessage(),
                'stack_strace' => $e->getTraceAsString()
            ]);
            DB::rollBack();

            throw new \RuntimeException(
                'Could not save you data right now. Please try again later.'
            );
        }

    }

    /**
     * @inheritDoc
     */
    public function update(array $inputs, int $id): ProductModel
    {
        // TODO: Implement update() method.
    }

    /**
     * @param array $inventories
     * @return array
     */
    private function stockCollection(array $inventories = []) : array {
        $newInventories = [];
        foreach ($inventories as $key => $inventory) {
            $newInventories[$key]['inventory_id'] = $inventory['pivot']['inventory_id'];
            $newInventories[$key]['quantity'] = $inventory['pivot']['quantity'];
        }
        return $newInventories;
    }
}
