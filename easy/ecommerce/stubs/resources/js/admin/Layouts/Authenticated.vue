<template>
    <div class="bg-gray-100 h-screen flex flex-col">
        <header class="flex justify-between items-center px-6 py-2 bg-white">
            <div class="shrink-0 flex items-center">
                <Link :href="route('admin.dashboard')">
                    <BreezeApplicationLogo class="block h-8 w-auto"/>
                </Link>
            </div>
            <div class="flex ml-3 relative">
                <SearchForm/>
                <AccountLink/>
            </div>
        </header>
        <div class="flex-1 flex overflow-hidden">
            <aside class="bg-admin-menu-900 w-72 overflow-x-hidden overflow-y-auto">
                <side-menu/>
            </aside>
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-2">
                <div class="flex justify-between align-middle">
                    <div class="flex-auto w-64">
                        <slot name="header"/>
                    </div>
                    <div class="flex-auto w-32" v-if="$slots.headerLink">
                        <slot name="headerLink"/>
                    </div>
                </div>
                <easy-notification :flash="$page.props.flash"/>
                <slot/>
            </main>
        </div>
    </div>
</template>

<script setup>
import BreezeApplicationLogo from '@/admin/Components/ApplicationLogo.vue'
import {Link} from '@inertiajs/inertia-vue3';
import AccountLink from '@/admin/Components/Dashboard/AccountLink.vue'
import SearchForm from '@/admin/Components/Dashboard/Search.vue'
import SideMenu from '@/admin/Components/Dashboard/Menu.vue'
import EasyNotification from "@/admin/Components/Notification";
</script>
