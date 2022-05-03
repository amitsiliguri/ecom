<template>
    <Head title="Admin Users"/>
    <EasyAuthenticatedLayout>
        <template #header> Admin Users</template>
        <template #headerLink>
            <EasyLink look="button" class="float-right" :link="route('admin.register')">
                Add New
            </EasyLink>
        </template>
        <easy-table :tableHead="tableHead" :tableData="$page.props.admins.data">
            <template #cell-active="{ row }">
                <template v-if="row.active">Yes</template>
                <template v-else>No</template>
            </template>
            <template #cell-email_verified_at="{ row }">
                <template v-if="row.email_verified_at == null">No</template>
                <template v-else>Yes</template>
            </template>
            <template #cell-actions="{ row }">
                <easy-link class="float-right" :link="route('admin.users.edit', row.id )">
                    Edit
                </easy-link>
            </template>
        </easy-table>
    </EasyAuthenticatedLayout>
</template>

<script>
import EasyAuthenticatedLayout from "@/admin/Layouts/Authenticated.vue";
import {Head} from "@inertiajs/inertia-vue3";
import EasyTable from "@/admin/Components/Table.vue";
import EasyLink from "@/admin/Components/Link.vue";

export default {
    components: {
        EasyAuthenticatedLayout,
        Head,
        EasyTable,
        EasyLink,
    },
    data() {
        return {
            tableHead: [
                {
                    align: "text-left",
                    label: "ID",
                    column: "id",
                },
                {
                    align: "text-center",
                    label: "Source",
                    column: "name",
                },
                {
                    align: "text-center",
                    label: "Email",
                    column: "email",
                },
                {
                    align: "text-center",
                    label: "Is Active?",
                    column: "active",
                },
                {
                    align: "text-center",
                    label: "Email Verified?",
                    column: "email_verified_at",
                },
                {
                    align: "text-right",
                    label: "Action",
                    column: "actions",
                },
            ],
        };
    },
};
</script>
