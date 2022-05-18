<template>
    <easy-table :tableHead="tableHead" :tableData="$page.props.customer.groups.data">
        <template #cell-status="{ row }">
            <template v-if="row.status">Yes</template>
            <template v-else>No</template>
        </template>
        <template #cell-actions="{ row }">
            <easy-link class="float-right" :link="route('admin.users.edit', row.id )">
                Edit
            </easy-link>
        </template>
    </easy-table>
</template>

<script setup>
import {reactive} from "vue";
import EasyTable from "@/admin/Components/Table.vue";
import EasyLink from "@/admin/Components/Link.vue";

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
