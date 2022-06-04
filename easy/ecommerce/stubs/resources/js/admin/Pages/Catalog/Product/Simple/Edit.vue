<template>
    <Head title="Create a new product"/>
    <EasyAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight my-6">
                Edit product
            </h2>
        </template>
        <simple-form
            :customerGroups="$page.props.user.customer.groups"
            :inventories="$page.props.catalog.product.inventories"
            :categories="$page.props.catalog.categories"
            :formData="$page.props.catalog.product.edit"
        />
    </EasyAuthenticatedLayout>
</template>

<script setup>
import EasyAuthenticatedLayout from "@/admin/Layouts/Authenticated.vue";
import {Head} from "@inertiajs/inertia-vue3";
import SimpleForm from '@/admin/Components/Catalog/Product/Simple/Form.vue'
</script>
