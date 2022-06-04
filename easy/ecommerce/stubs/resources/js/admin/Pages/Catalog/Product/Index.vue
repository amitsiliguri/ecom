<template>
    <Head title="Product List"/>
    <EasyAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight my-6">
                Product List
            </h2>
        </template>
        <template #headerLink>
            <EasyLink look="button" class="float-right" :link="route('admin.catalog.product.simple.create')">
                Add New
            </EasyLink>
        </template>

        <easy-table :tableHead="tableHead" :tableData="$page.props.products.data">
            <template #cell-status="{ row }">
                <template v-if="row.status">Yes</template>
                <template v-else>No</template>
            </template>
            <template #cell-actions="{ row }">
                <easy-link class="float-right" :link="route('admin.catalog.product.simple.edit', row.id )">
                    Edit
                </easy-link>
            </template>
        </easy-table>

    </EasyAuthenticatedLayout>
</template>

<script setup>
import {reactive} from "vue";
import EasyAuthenticatedLayout from "@/admin/Layouts/Authenticated.vue";
import {Head} from "@inertiajs/inertia-vue3";
import EasyLink from "@/admin/Components/Link.vue";
import EasyTable from "@/admin/Components/Table.vue";

const tableHead = reactive([
    {
        align: "text-left",
        label: "ID",
        column: "id",
    },
    {
        align: "text-center",
        label: "Title",
        column: "title",
    },
    {
        align: "text-center",
        label: "Is Active?",
        column: "status",
    },
    {
        align: "text-right",
        label: "Action",
        column: "actions",
    },
]);
</script>
