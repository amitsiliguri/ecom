<template>
    <ul v-if="items.length">
        <li v-for="(item, index) in items" :key="index"
            class="transition duration-75 text-admin-menu-400">
            <template v-if="item.children.length">
                <expansion-panel :open="item">
                    <template v-slot:expansionHeader>
                        <div
                            class="flex items-center items-stretch hover:text-white hover:bg-admin-menu-700 cursor-pointer"
                            @click="toggleExpansion(index)">
                            <p class="flex items-center p-3 text-base font-normal group grow">
                                <i class="mdi mx-2" :class="item.icon" aria-hidden="true"></i>
                                <span class="ml-3">{{ item.title }}</span>
                            </p>
                            <div class="w-12 grow-0 text-center pt-3">
                                <i class="mdi mdi-chevron-down" aria-hidden="true"></i>
                            </div>
                        </div>
                    </template>
                    <template v-slot:expansionContent>
                        <ChildMenu :child-menu="item.children"/>
                    </template>
                </expansion-panel>
            </template>
            <template v-else>
                <div class="flex items-center items-stretch hover:text-white hover:bg-admin-menu-700">
                    <easy-link :link="route(item.link)" class="flex items-center p-3 text-base font-normal group grow">
                        <i class="mdi mx-2" :class="item.icon" aria-hidden="true"></i>
                        <span class="ml-3">{{ item.title }}</span>
                    </easy-link>
                </div>
            </template>
        </li>
    </ul>
</template>

<script setup>
import {reactive} from "vue";
import ExpansionPanel from "@/admin/Components/Ui/ExpansionPanel";
import ChildMenu from "@/admin/Components/Dashboard/ChildMenu";
import EasyLink from "@/admin/Components/Link";

const items = reactive([
    {
        title: 'Dashboard',
        icon: 'mdi-view-dashboard-outline',
        link: 'admin.dashboard',
        children: [],
        open: false
    },
    // {
    //     title: 'Sales',
    //     icon: 'mdi-currency-usd',
    //     link: 'admin.sales.order.index',
    //     children: [
    //         {
    //             title: 'Orders', //type => Pending, Partial Pending, Invoices, Shipment( order complete from merchant's end / currier service will take charge) , Partial canceled, Canceled
    //             icon: 'mdi-view-dashboard-outline',
    //             link: 'admin.sales.order.index'
    //         },
    //         {
    //             title: 'Return Requests', //type => rejected, accepted, returned
    //             icon: 'mdi-view-dashboard-outline',
    //             link: 'admin.sales.return.index'
    //         },
    //     ],
    //     open: false
    // },
    {
        title: 'Users',
        icon: 'mdi-account-group-outline',
        // link: 'admin.customer.index',
        link: '',
        children: [{
            title: 'Customers',
            link: 'admin.catalog.category.create',
            icon: 'mdi-view-dashboard-outline'
        },
            {
                title: 'Customer Group', //type => rejected, accepted, returned
                link: 'admin.customer.group.index',
                icon: 'mdi-view-dashboard-outline'
            },],
        open: false
    },
    {
        title: 'Catalog',
        icon: 'mdi-book-multiple-outline',
        link: '',
        children: [
            {
                title: 'Categories',
                link: 'admin.catalog.category.create',
                icon: 'mdi-view-dashboard-outline'
            },
            {
                title: 'Products', //type => rejected, accepted, returned
                link: 'admin.catalog.product.index',
                icon: 'mdi-view-dashboard-outline'
            },
            {
                title: 'Inventory',
                link: 'admin.catalog.product.inventory.index',
                icon: 'mdi-view-dashboard-outline'
            },
        ],
        open: false
    },
    // {
    //     title: 'Marketing',
    //     icon: 'mdi-bullhorn-variant-outline',
    //     link: 'admin.dashboard',
    //     children: [
    //         {
    //             title: 'Category Discount',
    //             link: 'admin.dashboard',
    //             icon: 'mdi-view-dashboard-outline'
    //         },
    //         {
    //             title: 'Cart Discount',
    //             link: 'admin.dashboard',
    //             icon: 'mdi-view-dashboard-outline'
    //         },
    //     ],
    //     open: false
    // },
    {
        title: 'Admin Users',
        link: 'admin.users.index',
        icon: 'mdi-shield-crown-outline',
        children: [],
        open: false
    },
    // {
    //     title: 'Pages',
    //     link: 'admin.dashboard',
    //     icon: 'mdi-shield-crown-outline',
    //     children: [],
    //     open: false
    // },
    // {
    //     title: 'CMS Components',
    //     icon: 'mdi-content-paste',
    //     link: 'admin.dashboard',
    //     children: [
    //         {
    //             title: 'Carousel',
    //             link: 'admin.dashboard',
    //             icon: 'mdi-view-dashboard-outline'
    //         },
    //         {
    //             title: 'Logo',
    //             link: 'admin.dashboard',
    //             icon: 'mdi-view-dashboard-outline'
    //         },
    //         {
    //             title: 'Paragraph',
    //             link: 'admin.dashboard',
    //             icon: 'mdi-view-dashboard-outline'
    //         }
    //     ],
    //     open: false
    // }
]);

const toggleExpansion = (index) => {
    items[index].open = !items[index].open
    _.forEach(items, function (value, key) {
        if (key !== index && value.open === true) {
            items[key].open = false
        }
    });
}

</script>
