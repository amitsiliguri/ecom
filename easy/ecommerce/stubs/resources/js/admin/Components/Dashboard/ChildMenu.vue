<template>
    <ul>
        <template v-for="(childItem, childIndex) in childMenu" :key="childIndex">
            <li class="transition duration-75 text-admin-menu-400 hover:text-white hover:bg-admin-menu-700">
                <div class="flex items-center items-stretch">
                    <easy-link :link="route(childItem.link)" class="flex items-center p-3 text-base font-normal group grow">
                        <i class="mdi mx-2" :class="childItem.icon" aria-hidden="true"></i>
                        <span class="ml-3">{{ childItem.title }}</span>
                    </easy-link>
                </div>
            </li>
        </template>
    </ul>
</template>

<script setup>
import EasyLink from "@/admin/Components/Link";
const props = defineProps({
    childMenu: {
        type: Object,
        required: true,
        default: {
            title: '',
            icon: '',
            link: ''
        }
    }
})
</script>
