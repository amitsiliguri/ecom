<template>
    <Head title="Update Admin User"/>

    <easy-authenticated-layout>
        <template #header>Update Admin User</template>
        <template #headerLink>
            <easy-link look="button" class="float-right" :link="route('admin.users.index')">
                Go back
            </easy-link>
        </template>
        <admin-user-edit-form :form-data="$page.props.admin.user"/>
    </easy-authenticated-layout>
</template>

<script setup>
import EasyAuthenticatedLayout from "@/admin/Layouts/Authenticated.vue";
import AdminUserEditForm from "@/admin/Components/Admin/AdminUserForm.vue";
import {Head} from "@inertiajs/inertia-vue3";
import EasyLink from "@/admin/Components/Link.vue";
</script>
