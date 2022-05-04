<template>
    <Head title="Inventories"/>
    <EasyAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight my-6">
                Inventories
            </h2>
        </template>
        <inventory-form title="Update Inventory" description="Enter required details to update the inventory." :form-data="$page.props.inventory"/>
        <inventory-table/>
    </EasyAuthenticatedLayout>
</template>

<script setup>
import EasyAuthenticatedLayout from "@/admin/Layouts/Authenticated.vue";
import {Head} from "@inertiajs/inertia-vue3";
import InventoryForm from '@/admin/Components/Catalog/Product/Inventory/Form.vue';
import InventoryTable from '@/admin/Components/Catalog/Product/Inventory/Table.vue';
</script>
