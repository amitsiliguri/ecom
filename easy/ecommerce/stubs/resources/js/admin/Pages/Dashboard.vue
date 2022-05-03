<template>
    <Head title="Dashboard"/>

    <EasyAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight my-6">
                Dashboard
            </h2>
        </template>

        <div class="flex my-3">
            <div class="basis-1/4 px-2">
                <TotalUser />
            </div>
            <div class="basis-1/4 px-2">
                <TotalUser />
            </div>
            <div class="basis-1/4 px-2">
                <TotalUser />
            </div>
            <div class="basis-1/4 px-2">
                <TotalUser />
            </div>
        </div>

        <div class="flex my-3">
            <div class="basis-1/4 px-2">
                <RecentOrders />
            </div>
            <div class="basis-2/4 px-2">
                <SalesChart />
            </div>
            <div class="basis-1/4 px-2">
                <RecentOrders />
            </div>
        </div>


<!--        <accordion :data="accordionData" single/>-->
    </EasyAuthenticatedLayout>
</template>

<script setup>
import EasyAuthenticatedLayout from '@/admin/Layouts/Authenticated.vue'
import {Head} from '@inertiajs/inertia-vue3';
import Accordion from "@/admin/Components/Ui/Accordion";
import TotalUser from "@/admin/Components/Dashboard/TotlaUser";
import SalesChart from "@/admin/Components/Dashboard/SalesChart";
import RecentOrders from "@/admin/Components/Dashboard/RecentOrders";
import { reactive} from 'vue';

const accordionData = reactive(
    [
        {
            title: "Title One",
            content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
            open: true
        },
        {
            title: "Title Two",
            content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
            open: false
        },
        {
            title: "Title Three",
            content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
            open: false
        },
        {
            title: "Title Four",
            content: "Content Four",
            open: false
        }
    ]
)

</script>
