<template>
    <Head title="Edit Customer Group"/>
    <EasyAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight my-6">
                Edit Customer Group
            </h2>
        </template>
        <customer-group-form
            title="Edit Customer Group"
            description="Enter required details to create a new customer group."
            :form-data="$page.props.customer.group"
        />
    </EasyAuthenticatedLayout>
</template>

<script setup>
import EasyAuthenticatedLayout from "@/admin/Layouts/Authenticated.vue";
import {Head} from "@inertiajs/inertia-vue3";
import CustomerGroupForm from "@/admin/Components/Customer/Group/Form.vue"
</script>
