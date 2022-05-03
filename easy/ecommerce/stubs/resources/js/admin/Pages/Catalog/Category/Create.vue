<template>
    <Head title="Create Category"/>
    <EasyAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight my-6">
                Create Category
            </h2>
        </template>

        <div class="mb-12 mt-4 flex">
            <div class="flex-none w-96 px-2">
                <reorder-tree
                    :tree="$page.props.categories"
                    editRoute="admin.catalog.category.edit"
                    deleteRoute="admin.catalog.category.delete"
                    reorderRoute="admin.catalog.category.tree.reorder"
                />
            </div>
            <div class="flex-grow">
                <category-form />
            </div>
        </div>

    </EasyAuthenticatedLayout>
</template>

<script setup>
import EasyAuthenticatedLayout from '@/admin/Layouts/Authenticated.vue'
import {Head} from '@inertiajs/inertia-vue3';
import CategoryForm from '@/admin/Components/Catalog/Category/Form.vue'
import ReorderTree from '@/admin/Components/Catalog/Category/ReorderTree.vue'
</script>
