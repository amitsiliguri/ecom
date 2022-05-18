<template>
    <Head title="Customer Group Create"/>
    <EasyAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight my-6">
                Customer Group List
            </h2>
        </template>
        <template #headerLink>
            <EasyLink look="button" class="float-right" :link="route('admin.customer.group.create')">
                Add New
            </EasyLink>
        </template>
        <customer-group-table />
    </EasyAuthenticatedLayout>
</template>

<script setup>
import EasyAuthenticatedLayout from "@/admin/Layouts/Authenticated.vue";
import {Head} from "@inertiajs/inertia-vue3";
import EasyLink from "@/admin/Components/Link.vue";
import CustomerGroupTable from "@/admin/Components/Customer/Group/Table.vue";
</script>
