<template>
    <easy-table :tableHead="tableHead" :tableData="$page.props.inventories.data">
        <template #cell-status="{ row }">
            <template v-if="row.status">Yes</template>
            <template v-else>No</template>
        </template>
        <template #cell-actions="{ row }">

            <easy-link class="float-right inline-block" :link="route('admin.catalog.product.inventory.edit', row.id )">
                <i class="mdi mdi-pencil" aria-hidden="true"></i>
            </easy-link>

            <template v-if="row.id !== 1">
                <inventory-table-delete-action :id="row.id" />
            </template>


        </template>
    </easy-table>
</template>

<script setup>
import {reactive} from "vue";
import EasyTable from "@/admin/Components/Table.vue";
import EasyLink from "@/admin/Components/Link.vue";
import InventoryTableDeleteAction from '@/admin/Components/Catalog/Product/Inventory/Delete.vue';
const tableHead = reactive([
    // {
    //     align: "text-left",
    //     label: "ID",
    //     column: "id",
    // },
    {
        align: "text-left",
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
