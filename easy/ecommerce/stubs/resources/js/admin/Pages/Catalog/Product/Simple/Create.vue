<template>
    <Head title="Create a new product"/>
    <EasyAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight my-6">
                Create a new product
            </h2>
        </template>
<!--        <pre>-->
<!--            {{ $page.props.product }}-->
<!--        </pre>-->
        <simple-form :customerGroups="$page.props.customer_groups" :inventories="$page.props.inventories"/>
    </EasyAuthenticatedLayout>
</template>

<script setup>
import EasyAuthenticatedLayout from "@/admin/Layouts/Authenticated.vue";
import {Head} from "@inertiajs/inertia-vue3";
import SimpleForm from '@/admin/Components/Catalog/Product/Simple/Form.vue'
</script>
