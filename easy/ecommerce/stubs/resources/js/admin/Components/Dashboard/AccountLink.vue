<template>
    <EasyDropdown align="right" width="48">
        <template #trigger>
            <span class="inline-flex rounded-md">
                <button type="button"
                        class="inline-flex items-center my-1 p-3 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                    {{ $page.props.auth.user.name }}

                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                              clip-rule="evenodd"/>
                    </svg>
                </button>
            </span>
        </template>

        <template #content>
            <a :href="route('front')" target="_blank"
               class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                Customer View
            </a>
            <EasyDropdownLink :href="route('admin.logout')" method="post" as="button">
                Log Out
            </EasyDropdownLink>
        </template>
    </EasyDropdown>
</template>

<script>
import EasyDropdown from '@/admin/Components/Dropdown.vue'
import EasyDropdownLink from "@/admin/Components/DropdownLink";

export default {
    components: {
        EasyDropdown,
        EasyDropdownLink
    }
}
</script>
