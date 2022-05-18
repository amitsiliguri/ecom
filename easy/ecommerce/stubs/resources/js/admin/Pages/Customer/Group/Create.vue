<template>
    <Head title="Create a new Customer Group"/>
    <EasyAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight my-6">
                Create a new Customer Group
            </h2>
        </template>
        <customer-group-form title="Create Customer Group" description="Enter required details to create a new customer group." />
    </EasyAuthenticatedLayout>
</template>

<script setup>
import EasyAuthenticatedLayout from "@/admin/Layouts/Authenticated.vue";
import {Head} from "@inertiajs/inertia-vue3";
import CustomerGroupForm from "@/admin/Components/Customer/Group/Form.vue"
</script>
