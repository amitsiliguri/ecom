<template>
    <div>
        <easy-button @click="toggleModal(true)" type="button">
            Advance Price
        </easy-button>

            <dialog-modal :show="modal.status" max-width="7xl" @close="toggleModal(false)">
                <template #title>
                    <div class="flex justify-between">
                        <h3>Tier Prices</h3>
                        <easy-button @click="addNewTierPrice()" type="button">
                            ADD NEW
                        </easy-button>
                    </div>
                </template>

                <template #content>
                    <template v-if="tierPriceData.length > 0">
                        <div v-for="(tier_price,index) in tierPriceData" :key="index" class="flex my-2">
                            <div class="grow pr-2">
                                <easy-input label="Qty" :id="'qty' + index" type="number" v-model="tier_price.quantity"/>
                            </div>
                            <div class="w-48 px-2">
                                <div class="block my-4">
                                    <easy-label value="Customer Group" />
                                    <tree-select v-model="data.value" :multiple="false" :options="data.options" class="mt-1"/>
                                </div>
                            </div>
                            <div class="grow px-2">
                                <easy-input label="Offer Price" :id="'special_price' + index" type="text" v-model="tier_price.special_price"/>
                            </div>
                            <div class="grow px-2">
                                <easy-input label="Offer start date" :id="'offer_start' + index" type="date" v-model="tier_price.offer_start"/>
                            </div>
                            <div class="grow px-2">
                                <easy-input label="Offer end date" :id="'offer_end' + index" type="date" v-model="tier_price.offer_end"/>
                            </div>
                            <div class="w-16 pl-2 flex items-end">
                                <easy-danger-button class="mb-4 py-3" @click="removeTierPrice(index)" v-if="index > 0">
                                    <i class="mdi mdi-delete-outline" aria-hidden="true"></i>
                                </easy-danger-button>
                            </div>
                        </div>
                    </template>
                </template>

                <template #footer>
                    <easy-button @click="toggleModal(false)" type="button">
                        SAVE
                    </easy-button>
                </template>
            </dialog-modal>
    </div>
</template>

<script setup>
import { reactive } from 'vue';
import TreeSelect from 'vue3-treeselect'
import 'vue3-treeselect/dist/vue3-treeselect.css'
import DialogModal from '@/admin/Components/Ui/DialogModal.vue'
import EasyButton from "@/admin/Components/Form/Button.vue";
import EasyInput from "@/admin/Components/Form/Input.vue";
import EasyDangerButton from "@/admin/Components/Form/DangerButton.vue";
import EasySelect from '@/admin/Components/Form/Select.vue';
import EasyLabel from "@/admin/Components/Form/Label.vue";
const props = defineProps({
    tierPrices: {
        type: Array,
        required: true,
        default() {
            return [
                {
                    id: null,
                    quantity: 1,
                    special_price: '0000.0000',
                    customer_group_id: 1,
                    offer_start: new Date().toISOString().substring(0, 10),
                    offer_end: new Date().toISOString().substring(0, 10),
                    product_id: null
                }
            ]
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
    }
})

let modal = reactive({
    status: false
})

let tierPriceData = reactive([])

tierPriceData = props.tierPrices

const toggleModal = (status) => {
   return modal.status = status
}

const addNewTierPrice = () => {
    tierPriceData.push(
        {
            id: null,
            quantity: 1,
            special_price: '0000.0000',
            customer_group_id: 1,
            offer_start: new Date().toISOString().substring(0, 10),
            offer_end: new Date().toISOString().substring(0, 10),
            product_id: null
        }
    );
}


const removeTierPrice = (index) => {
    tierPriceData.splice(index, 1)
}

let data = reactive({
    value: null,
    options: [{
        id: 'a',
        label: 'a',
        children: [{
            id: 'aa',
            label: 'aa',
        }, {
            id: 'ab',
            label: 'ab',
        }],
    }, {
        id: 'b',
        label: 'b',
    }, {
        id: 'c',
        label: 'c',
    }]
})
</script>
