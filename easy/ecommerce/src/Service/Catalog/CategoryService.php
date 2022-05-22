<?php

declare(strict_types=1);

namespace Easy\Ecommerce\Service\Catalog;

use Easy\Ecommerce\Contracts\Catalog\CategoryServiceInterface;
use Easy\Ecommerce\Model\Catalog\Category as CategoryModel;
use Easy\Ecommerce\Contracts\FileUploadInterface;
use Easy\Ecommerce\Contracts\Catalog\Category\TreeInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * @package Easy\Ecommerce
 * @namespace Easy\Ecommerce\Service\Catalog
 * @CategoryService
 */
class CategoryService implements CategoryServiceInterface
{
    /**
     * @var TreeInterface
     */
    protected TreeInterface $tree;

    /**
     * @var FileUploadInterface
     */
    protected FileUploadInterface $fileUpload;

    /**
     * @var CategoryModel
     */
    protected CategoryModel $categoryModel;

    /**
     * @param TreeInterface $tree
     * @param FileUploadInterface $fileUpload
     * @param CategoryModel $categoryModel
     */
    public function __construct(
        TreeInterface $tree,
        FileUploadInterface $fileUpload,
        CategoryModel $categoryModel
    ) {
        $this->tree = $tree;
        $this->fileUpload = $fileUpload;
        $this->categoryModel = $categoryModel;
    }

    /**
     * @inheritdoc
     */
    public function store(array $inputs): CategoryModel
    {
        $bannerImagePath = (array_key_exists('banner', $inputs)) ? $this->fileUpload->createResizedImagePath($inputs['banner'], self::BANNER_PATH, 300) : [$this->fileUpload::NO_FILE_PLACEHOLDER_PATH];
        $metaImagePath = (array_key_exists('meta_image', $inputs)) ? $this->fileUpload->createResizedImagePath($inputs['meta_image'], self::META_IMAGE_PATH, 300) : [$this->fileUpload::NO_FILE_PLACEHOLDER_PATH];
        return $this->categoryModel::create([
            'status' => $inputs['status'],
            'title' => $inputs['title'],
            'slug' => $inputs['slug'],
            'banner' => $bannerImagePath[0],
            'description' => $inputs['description'],
            'meta_image' => $metaImagePath[0],
            'meta_title' => $inputs['meta_title'],
            'meta_description' => $inputs['meta_description']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getReorderedCategory(): array
    {
        return $this->tree->getTree(
            $this->getList(
                false,
                ['id', 'title', 'parent_id', 'sort_order'],
                [],
                0,
                'sort_order',
                'ASC'
            )->toArray()
        );
    }


    /**
     * @inheritdoc
     */
    public function saveReorder(mixed $tree, int $parentId = 0): void
    {
        $this->tree->saveTree($this->categoryModel, $tree, $parentId);
    }

    /**
     * @param int $id
     * @return CategoryModel
     */
    public function getById(int $id): CategoryModel
    {
        return $this->categoryModel::findOrFail($id);
    }


    /**
     * @inheritdoc
     */
    public function update(array $inputs, int $id): CategoryModel
    {
        $bannerImagePath = (array_key_exists('banner', $inputs)) ? $this->fileUpload->updateResizedImagePath($inputs['banner'], self::BANNER_PATH, 300) : [$this->fileUpload::NO_FILE_PLACEHOLDER_PATH];
        $metaImagePath = (array_key_exists('meta_image', $inputs)) ? $this->fileUpload->updateResizedImagePath($inputs['meta_image'], self::META_IMAGE_PATH, 300) : [$this->fileUpload::NO_FILE_PLACEHOLDER_PATH];
        $this->categoryModel::where('id', $id)->update([
            'status' => $inputs['status'],
            'title' => $inputs['title'],
            'slug' => $inputs['slug'],
            'banner' => $bannerImagePath[0],
            'description' => $inputs['description'],
            'meta_image' => $metaImagePath[0],
            'meta_title' => $inputs['meta_title'],
            'meta_description' => $inputs['meta_description']
        ]);
        return $this->getById( $id);
    }

    /**
     * @inheritdoc
     */
    public function delete( int $id): CategoryModel
    {
        $category = $categoryTemp = $this->getById($id);
        if ($category->banner !== $this->fileUpload::NO_FILE_PLACEHOLDER_PATH && $category->banner !== null ) {
            $this->fileUpload->deleteFileFromDirectory($category->banner);
        }
        if ($category->meta_image !== $this->fileUpload::NO_FILE_PLACEHOLDER_PATH && $category->meta_image !== null ) {
            $this->fileUpload->deleteFileFromDirectory($category->banner);
        }
        $category->delete();
        return $categoryTemp;
    }

    public function getList(
        bool $isPaginated = true,
        array $select = self::CATALOG_CATEGORY_MAIN_TABLE,
        array $conditions = [],
        int $paginate = 10,
        string $sortBy = 'id',
        string $direction = 'DESC'
    ): LengthAwarePaginator|Collection
    {
        $list = $this->categoryModel::select($select)->orderBy($sortBy, $direction);
        if (count($conditions)) {
            foreach ($conditions as $condition){
                if (
                    array_key_exists('column',$condition) &&
                    array_key_exists('operator',$condition) &&
                    array_key_exists('value',$condition)
                ) {
                    $list->where($condition['column'],$condition['operator'],$condition['value']);
                }
            }
        }
        if ($isPaginated) {
           return $list->paginate($paginate);
        }
        return $list->get();
    }
}
