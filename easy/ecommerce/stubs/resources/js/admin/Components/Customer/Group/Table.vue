<template>
    <easy-table :tableHead="tableHead" :tableData="$page.props.customer.groups.data">
        <template #cell-status="{ row }">
            <template v-if="row.status">Yes</template>
            <template v-else>No</template>
        </template>
        <template #cell-actions="{ row }">
            <template v-if="row.id !== 1">
                <delete-customer-group
                    :id="row.id"
                    url="admin.customer.group.delete"
                    title="Delete Customer Group"
                />
            </template>
            <easy-link class="float-right" :link="route('admin.customer.group.edit', row.id )">
                <i class="mdi mdi-pencil" aria-hidden="true"></i>
            </easy-link>
        </template>
    </easy-table>
</template>

<script setup>
import {reactive} from "vue";
import EasyTable from "@/admin/Components/Table.vue";
import EasyLink from "@/admin/Components/Link.vue";
import DeleteCustomerGroup from '@/admin/Components/Ui/DeleteModal.vue';

const tableHead = reactive([
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
