<template>
    <easy-form-section @submitted="submit()">
        <template #title>
            Product Form
        </template>

        <template #description>
            Fill up all the required details to create/update a product.
        </template>
        <template #form>
            <easy-check-box label="Is Product Active?" id="status" v-model:checked="form.status"
                            :error="form.errors.status"/>
            <easy-input label="Title" id="title" type="text" v-model="form.title" autofocus :error="form.errors.title"/>
            <easy-file-upload label="Product Images" id="banner" v-model="form.images" multiple/>
            <div class="block my-4">
                <EasyLabel for="small_description" value="Small Description"/>
                <editor id="small_description" :api-key="key" :init="initEditor(200)" v-model="form.small_description"/>
                <easy-input-error :message="form.errors.small_description"/>
            </div>
            <div class="block my-4">
                <EasyLabel for="description" value="Description"/>
                <editor id="description" :api-key="key" :init="initEditor(500)" v-model="form.description"/>
                <easy-input-error :message="form.errors.description"/>
            </div>
            <easy-input label="Slug" id="slug" type="text" v-model="form.slug" :error="form.errors.slug"/>
            <easy-input label="Meta Title" id="meta_title" type="text" v-model="form.meta_title"
                        :error="form.errors.meta_title"/>
            <easy-text-area label="Meta Description" id="meta_description" v-model="form.meta_description"
                            :error="form.errors.meta_description"/>
            <easy-file-upload label="Meta Image" id="meta_image" v-model="form.meta_image"/>



            <div>
                <h4 class="text-2xl">Categories</h4>
            </div>
            <div class="flex my-2 space-x-2">
                <tree-select v-model="form.categories" :multiple="true" value-consists-of="ALL" :options="computedCategoryTree"/>
            </div>


            <div class="flex justify-between">
                <h4 class="text-2xl">Price</h4>
                <tier-price :tier-prices="form.tier_prices" :customer-groups="customerGroups" @tierPricesInputs="getTierPriceInputs"/>
            </div>
            <div class="flex my-2 space-x-2">
                <div class="grow">
                    <easy-input label="MRP" id="base_price" type="text" v-model="form.price.base_price" :error="form.errors[`prices.base_price`]"/>
                </div>
                <div class="grow">
                    <easy-input label="Offer" id="special_price" type="text" v-model="form.price.special_price" :error="form.errors[`prices.special_price`]"/>
                </div>
                <div class="grow">
                    <easy-input label="Offer Start Date" id="offer_start" type="date" v-model="form.price.offer_start" :error="form.errors[`prices.offer_start`]"/>
                </div>
                <div class="grow">
                    <easy-input label="Offer End Date" id="offer_end" type="date" v-model="form.price.offer_end" :error="form.errors[`prices.offer_end`]"/>
                </div>
            </div>



            <div class="flex justify-between">
                <h4 class="text-2xl">Inventories</h4>
                <template v-if="form.maintain_stock">
                    <inventories :selected-inventories="form.inventories" :available-inventories="props.inventories" @inventoryInputs="getInventoryInputs"/>
                </template>
            </div>
            <div class="flex mt-2 mb-12 space-x-2">
                <div class="w-1/4">
                    <easy-check-box label="Is available for sale?" id="in_stock" v-model:checked="form.in_stock" :error="form.errors.in_stock"/>
                </div>
                <div class="w-3/4">
                    <easy-check-box label="Manage Stock?" id="manage_stock" v-model:checked="form.maintain_stock" :error="form.errors.maintain_stock"/>
                </div>
            </div>

        </template>

        <template #actions>
            <div class="flex justify-between">
                <easy-action-message :on="form.recentlySuccessful" class="mr-3">
                    Saved.
                </easy-action-message>

                <easy-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Save
                </easy-button>
            </div>
        </template>
    </easy-form-section>
</template>

<script setup>
import { computed, reactive } from 'vue';
import TreeSelect from 'vue3-treeselect'
import 'vue3-treeselect/dist/vue3-treeselect.css'
import {useForm} from '@inertiajs/inertia-vue3'

import {imagePreview} from '@/admin/Composable/ImagePreview.js'
import EasyActionMessage from "@/admin/Components/Form/ActionMessage.vue";
import EasyFormSection from "@/admin/Components/Form/FormSection.vue";
import EasyButton from "@/admin/Components/Form/Button.vue";
import EasyInput from "@/admin/Components/Form/Input.vue";
import EasyInputError from "@/admin/Components/Form/InputError.vue";
import EasyLabel from "@/admin/Components/Form/Label.vue";
import Editor from "@tinymce/tinymce-vue";
import EasyTextArea from "@/admin/Components/Form/TextArea.vue";
import EasyCheckBox from "@/admin/Components/Form/Checkbox";
import EasyFileUpload from '@/admin/Components/Form/FileUpload.vue';
import TierPrice from '@/admin/Components/Catalog/Product/Simple/Form/TierPrice.vue'
import Inventories from '@/admin/Components/Catalog/Product/Simple/Form/Inventories.vue'
import {initTinyMCE} from '@/admin/Composable/TinyMCE.js'
import {keyMapping} from '@/admin/Composable/KeyMapping'
import {Tree} from '@/admin/Composable/Tree'

const {nest} = Tree();
const {initializeKeyMapping} = keyMapping();
const {key, initEditor} = initTinyMCE();
const {getPreviewImage, constructImageObject, getMultiplePreviewImages} = imagePreview();

const props = defineProps({
    formData: {
        type: Object,
        required: false,
        default() {
            return {
                id: null,
                status: true,
                sku: "",
                title: "",
                small_description: "",
                description: "",
                type: "simple",
                maintain_stock: true,
                in_stock: true,
                images: [
                    {
                        id: null,
                        image: '',
                        type: 'small',
                        alt_name: '',
                        product_id: null
                    }
                ],
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
                inventories: [
                    {
                        id: null,
                        status: true,
                        title: '',
                        pivot: {
                            product_id: null,
                            inventory_id: null,
                            quantity: 0
                        }
                    }
                ],
                categories: [
                    {
                        id: null,
                        status: true,
                        title: '',
                        slug: '',
                        pivot: {
                            product_id: null,
                            inventory_id: null
                        }
                    }
                ]
            }
        }
    },
    customerGroups: {
        type: Array,
        required: true,
        default() {
            return [
                {
                    id: 1,
                    title: "Default"
                }
            ]
        }
    },
    inventories: {
        type: Array,
        required: true,
        default() {
            return [
                {
                    id: 1,
                    title: "Default"
                }
            ]
        }
    },
    categories: {
        type: Array,
        required: true
    },
})

const computedCategoryTree = computed(() => {
    let formattedCategories = initializeKeyMapping(props.categories, {title: 'label'})
    return nest(formattedCategories)
})

let data = reactive({
    value: null
})

/**
 *
 * @param propsFormDataInventories
 * @returns {*}
 */

const form = useForm({
    _method: (props.formData.id) ? 'PUT' : 'POST',
    id: props.formData.id,
    status: Boolean(props.formData.status),
    title: props.formData.title,
    small_description: props.formData.small_description,
    description: props.formData.description,
    type: props.formData.type,
    maintain_stock: props.formData.maintain_stock,
    in_stock: props.formData.in_stock,
    slug: props.formData.slug,
    meta_title: props.formData.meta_title,
    meta_description: props.formData.meta_title,
    meta_image: getPreviewImage(
        props.formData.id,
        props.formData.meta_image,
        props.formData.meta_title
    ),
    images: getMultiplePreviewImages(props.formData.images),
    price: props.formData.price,
    tier_prices: props.formData.tier_prices,
    inventories: props.formData.inventories,
    categories: null
})

const getTierPriceInputs = (val) => {
    form.tier_prices = val
}

const getInventoryInputs = (val) => {
    form.inventories = val
}

function submit() {
    console.log(form)
    // let url = (form.id) ? route('admin.catalog.category.update', form.id) : route('admin.catalog.category.store');
    // form.transform((data) => ({
    //     ...data,
    //     status: (data.status) ? 1 : 0,
    //     banner: constructImageObject(data.banner),
    //     meta_image: constructImageObject(data.meta_image),
    // })).post(url,{
    //     errorBag: 'catalogCategory',
    //     onSuccess: () => {
    //         form.reset()
    //
    //     }
    // })
}
</script>
