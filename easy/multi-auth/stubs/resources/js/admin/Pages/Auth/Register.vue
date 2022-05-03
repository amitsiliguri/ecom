<template>
    <Head title="Register"/>

    <EasyAuthenticatedLayout>
        <template #header> Add New Admin User</template>
        <template #headerLink>
            <EasyLink look="button" class="float-right" :link="route('admin.users.index')">
                Go back
            </EasyLink>
        </template>

        <easy-registration-form />
    </EasyAuthenticatedLayout>
</template>

<script setup>
import EasyAuthenticatedLayout from "@/admin/Layouts/Authenticated.vue";
import EasyRegistrationForm from "@/admin/Components/Admin/AdminUserForm.vue";
import {Head} from "@inertiajs/inertia-vue3";
import EasyLink from "@/admin/Components/Link.vue";
</script>
