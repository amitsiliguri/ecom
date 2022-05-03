<?php

namespace Easy\Ecommerce\Contracts\Catalog\Category;

interface TreeInterface
{
    /**
     * getTree
     *
     * @param array $arrayList
     * @param bool $isSortRequired
     * @return array
     */
    public function getTree(array $arrayList, bool $isSortRequired = false): array;

    /**
     * @param object $model
     * @param array $tree
     * @param int $parentId
     * @return void
     */
    public function saveTree(object $model,array $tree, int $parentId): void;
}
