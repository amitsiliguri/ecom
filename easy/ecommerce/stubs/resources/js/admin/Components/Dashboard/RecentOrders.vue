<template>
    <card full-height>
        <template #header>
            <h3 class="text-sm">Recent Orders</h3>
        </template>
        <easy-table :tableHead="tableHead" :tableData="tableData" class="p-2"/>
        <template #footer>
            <p class="text-center">View All</p>
        </template>
    </card>
</template>

<script setup>
import Card from "@/admin/Components/Ui/Card";
import EasyTable from "@/admin/Components/Table.vue";
import {reactive} from "vue";
const tableHead = reactive( [
    {
        align: "text-left",
        label: "Order ID",
        column: "id",
    },
    {
        align: "text-right",
        label: "Total",
        column: "total",
    },
])

const tableData = reactive([
    {
        id: '123123',
        total: '1000.98'
    },
    {
        id: '123123',
        total: '1000.98'
    },
    {
        id: '123123',
        total: '1000.98'
    },
    {
        id: '123123',
        total: '1000.98'
    },
    {
        id: '123123',
        total: '1000.98'
    },
    {
        id: '123123',
        total: '1000.98'
    }
])

</script>
