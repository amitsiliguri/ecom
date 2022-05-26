<template>
    <div>
        <easy-button @click="toggleModal(true)" type="button">
            Advance Inventories
        </easy-button>

        <dialog-modal :show="data.modal_status" max-width="7xl" @close="toggleModal(false)">
            <template #title>
                <div class="flex justify-between">
                    <h3>Stocks & Inventories</h3>
                    <easy-custom-select
                        id="available_inventories"
                        :options="props.availableInventories"
                        :mapKeys="{value: 'id', label: 'title'}"
                        v-model="data.selected_ids"
                        placeholder="Select Inventories"
                        multiple
                        class="w-60"
                    />
                </div>
            </template>

            <template #content>
                <template v-if="data.selected_inventories.length > 0">
                    <div v-for="(inventory,index) in data.selected_inventories" :key="index" class="flex my-2">
                        <div class="grow pr-2">
                            <easy-input label="Inventory" :id="'inventory_title_' + index" type="text" v-model="inventory.title" disabled/>
                        </div>
                        <div class="w-48 px-2">
                            <easy-input label="Quantity" :id="'inventory_quantity_' + index" type="text" v-model="inventory.pivot.quantity" :disabled="!inventory.status"/>
                        </div>
                    </div>
                </template>

            </template>

            <template #footer>
                <easy-button @click="saveModal()" type="button">
                    SAVE
                </easy-button>
            </template>
        </dialog-modal>
    </div>
</template>

<script setup>
import _ from 'lodash';
import {onMounted, reactive, watch} from "vue";
import DialogModal from '@/admin/Components/Ui/DialogModal.vue'
import EasyButton from "@/admin/Components/Form/Button.vue";
import EasyInput from "@/admin/Components/Form/Input.vue";
import EasyCustomSelect from '@/admin/Components/Form/CustomSelect.vue';

const props = defineProps({
    availableInventories: {
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
    selectedInventories: {
        type: Array,
        required: true,
        default() {
            return [
                {
                    id: null,
                    status: true,
                    title: '',
                    pivot: {
                        quantity: 0,
                        inventory_id: null,
                    }
                }
            ]
        }
    }
})

const emit = defineEmits(['inventoryInputs'])

const data = reactive({
    modal_status: false,
    selected_ids: [],
    selected_inventories: []
})

onMounted(() => {
   setSelectedInventoriesAndIds()
})

const toggleModal = (status) => {
    return data.modal_status = status
}

const saveModal = () => {
    emit('inventoryInputs', data.selected_inventories)
    toggleModal(false)
}

watch(() => [...data.selected_ids], (newValue, oldValue) => {
    if (newValue.length > oldValue.length) {
        let def = getDifference(newValue, oldValue)
        let value = _.find(props.availableInventories, ['id', def[0]]);
        data.selected_inventories.push({
            id: value.id,
            status: true,
            title: value.title,
            pivot: {
                quantity: 0,
                inventory_id: value.id,
            }
        });
    } else {
        let def = getDifference(oldValue, newValue)
        _.remove(data.selected_inventories, {id : def[0]});
    }
})

const getDifference = (newValue, oldValue) => {
    return _.difference( _.values(newValue), _.values(oldValue))
}

const setSelectedInventoriesAndIds = () => {
    if (props.selectedInventories.length === 1 && props.selectedInventories[0].id === null) {
        let value = _.find(props.availableInventories, ['id', 1]);
        data.selected_ids.push(value.id)
    } else if(props.selectedInventories.length > 1){
        _.forEach(props.selectedInventories, function(item) {
            if (item.id != null) {
                data.selected_ids.push(item.id)
            }
        });
        data.selected_inventories = props.selectedInventories
    }
}


</script>
