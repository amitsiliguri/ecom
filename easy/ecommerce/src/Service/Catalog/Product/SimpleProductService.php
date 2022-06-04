<?php

namespace Easy\Ecommerce\Service\Catalog\Product;

use Easy\Ecommerce\Contracts\Catalog\Product\SimpleProductServiceInterface;
use Easy\Ecommerce\Contracts\FileUploadInterface;
use Easy\Ecommerce\Model\Catalog\Product as ProductModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SimpleProductService implements SimpleProductServiceInterface
{

    /**
     * @var FileUploadInterface
     */
    protected FileUploadInterface $fileUpload;

    protected ProductModel $productModel;

    public function __construct(
        FileUploadInterface $fileUpload,
        ProductModel $productModel
    ) {
        $this->fileUpload = $fileUpload;
        $this->productModel = $productModel;
    }

    /**
     * @inheritDoc
     */
    public function store(array $inputs): void
    {
        $now = now();
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/inputs'.$now.'.log'),
        ])->error([
            'message' => $inputs,
        ]);

        DB::beginTransaction();
        try {
            $slug = $this->createURL($inputs['slug'],$inputs['title']);

            $metaImagePath = (array_key_exists('meta_image', $inputs)) ?
                $this->fileUpload->createResizedImagePath(
                    $inputs['meta_image'], self::META_IMAGE_PATH, 627) :
                    [$this->fileUpload::NO_FILE_PLACEHOLDER_PATH];

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
                'meta_image' => $metaImagePath[0],
                'slug' => $slug,
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
                (int) $inputs['in_stock'] === 1 &&
                array_key_exists("stocks",$inputs) &&
                is_array($inputs['stocks']) &&
                count($inputs['stocks']) > 0
            ) {
                $newProduct->stocks()->createMany($inputs['stocks']);
            }
            $newProduct->categories()->sync($inputs['categories']);
            $newProduct->price()->create($inputs['price']);
            // add images to product
            // TODO:: Upload multiple image sizes at once
            // TODO:: Store alt_name
            $imagePath = (array_key_exists('images', $inputs)) ? $this->fileUpload->createResizedImagePath($inputs['images'], self::IMAGE_PATH, 500) : [$this->fileUpload::NO_FILE_PLACEHOLDER_PATH];
            if (count($imagePath)){
                $newProduct->images()->createMany($this->productImages($imagePath, $inputs['title']));
            }
            // add categories to product
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
                'Could not save the product right now. Please try again later.'
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

    protected function createURL(string $slug, string $title = null): string
    {
        $url = ($slug === '') ? $title : $slug;
        if ($url === null || $url === ''){
            throw new \RuntimeException(
                'Title and Slug can not be empty at the same time.'
            );
        }
        $url = trim($url);
        $url = strtolower($url);
        $url = preg_replace('/\s+/', '-', $url);
        if (empty($url)) {
            return 'n-a';
        }
        return $url;
    }


    /**
     * This function will be removed
     *
     * @param array $imagePath
     * @param string $title
     * @return array
     */
    private function productImages(array $imagePath, string $title) : array
    {
        $tempImageArray = [];
        foreach ($imagePath as $key => $value) {
//            $tempImageArray[$key]['type'] = 'additional';
            $tempImageArray[$key]['image'] = $value;
            $tempImageArray[$key]['alt_name'] = $title;
        }
        return $tempImageArray;
    }
}
