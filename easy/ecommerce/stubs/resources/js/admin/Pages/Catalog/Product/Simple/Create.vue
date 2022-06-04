<template>
    <Head title="Create a new product"/>
    <EasyAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight my-6">
                Create a new product
            </h2>
        </template>
        <simple-form
            :customerGroups="$page.props.user.customer.groups"
            :inventories="$page.props.catalog.product.inventories"
            :categories="$page.props.catalog.categories"
            :formData="form.default"
        />
    </EasyAuthenticatedLayout>
</template>

<script setup>
import {reactive} from 'vue';
import EasyAuthenticatedLayout from "@/admin/Layouts/Authenticated.vue";
import {Head} from "@inertiajs/inertia-vue3";
import SimpleForm from '@/admin/Components/Catalog/Product/Simple/Form.vue'


let form = reactive({
    default: {
        id: null,
        status: true,
        sku: "",
        title: "",
        small_description: "",
        description: "",
        type: "simple",
        maintain_stock: true,
        in_stock: true,
        images: [],
        slug: "",
        meta_title: "",
        meta_description: "",
        meta_image: '',
        price: {
            id: null,
            base_price: '0000.0000',
            special_price: '0000.0000',
            offer_start: new Date().toISOString().substring(0, 10),
            offer_end: new Date().toISOString().substring(0, 10),
            product_id: null
        },
        tier_prices: [
            {
                id: null,
                quantity: 1,
                special_price: '0000.0000',
                customer_group_id: 1,
                offer_start: new Date().toISOString().substring(0, 10),
                offer_end: new Date().toISOString().substring(0, 10),
                product_id: null
            }
        ],
        stocks: [
            {
                quantity: 0,
                reserved_quantity: 0,
                product_id: 0,
                inventory_id: 1
            }
        ],
        categories: []
    }
})

</script>
