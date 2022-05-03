<?php

namespace Easy\Ecommerce\Service\Catalog\Category;

use Easy\Ecommerce\Contracts\Catalog\Category\TreeInterface;

class Tree implements TreeInterface
{
    /**
     * @inheritDoc
     */
    public function getTree(array $arrayList, bool $isSortRequired = false): array
    {
        $new = [];
        if ($isSortRequired && count($arrayList) > 1) {
            array_multisort(array_column($arrayList, 'sort_order'), SORT_ASC, $arrayList);
        }
        if (count($arrayList) > 0) {
            foreach ($arrayList as $arrayItem) {
                $arrayItem['children'] = [];
                $new[$arrayItem['parent_id']][] = $arrayItem;
            }
            return $this->createTree($new, $new[0]);
        } else {
            return [];
        }
    }

    /**
     * @param $arrayList
     * @param $parents
     * @return array
     */
    private function createTree(&$arrayList, $parents): array
    {
        $tree = [];
        foreach ($parents as $parent) {
            if (isset($arrayList[$parent['id']])) {
                $parent['children'] = $this->createTree($arrayList, $arrayList[$parent['id']]);
            }
            $tree[] = $parent;
        }
        return $tree;
    }


    /**
     * @inheritDoc
     */
    public function saveTree(object $model, array $tree, int $parentId): void
    {
        foreach ($tree as $key => $item) {
            $foundCategory = $model::find($item['id']);
            $foundCategory->parent_id = $parentId;
            $foundCategory->sort_order = $key;
            $foundCategory->save();
            if (count($item['children']) > 0 ) {
                $this->saveTree($model, $item['children'], $item['id']);
            }
        }
    }
}
