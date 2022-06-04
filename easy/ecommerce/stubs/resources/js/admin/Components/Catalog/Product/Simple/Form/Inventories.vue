<template>
    <div  class="flex mt-2 mb-2 space-x-2">
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
    <template v-if="data.selected_stocks.length > 0">
        <div v-for="(stock,index) in data.selected_stocks" :key="index" class="flex mb-1 w-full">
            <div class="grow pr-2">
                <easy-input label="Inventory" :id="'inventory_title_' + index" type="text" v-model="stock.inventory_title"
                            disabled/>
            </div>
            <div class="w-48 px-2">
                <easy-input label="Quantity" :id="'inventory_quantity_' + index" type="text" v-model="stock.quantity"/>
            </div>
            <div class="w-48 px-2">
                <easy-input label="Reserved Quantity" :id="'inventory_reserved_quantity_' + index" type="text" v-model="stock.reserved_quantity" disabled/>
            </div>
        </div>
    </template>
</template>

<script setup>
import _ from 'lodash';
import {onMounted, reactive, watch} from "vue";
import EasyInput from "@/admin/Components/Form/Input.vue";
import EasyCustomSelect from '@/admin/Components/Form/CustomSelect.vue';

const props = defineProps({
    availableInventories: {
        type: Array,
        required: true
    },
    selectedInventories: {
        type: Array,
        required: true
    }
})

const emit = defineEmits(['inventoryInputs'])

const data = reactive({
    selected_ids: [],
    selected_stocks: [],
    is_dirty: false,
})

onMounted(() => {
    setSelectedInventoriesAndIds()
})

watch(() => [...data.selected_ids], (newValue, oldValue) => {
    if (newValue.length > oldValue.length) {
        let def = getDifference(newValue, oldValue)
        _.forEach(def, function (id) {
            let value = _.find(props.availableInventories, ['id', id]);
            let exists = _.find(props.selectedInventories, ['inventory_id', id]);
            if (exists){
                exists.inventory_id = value.id
                exists.inventory_title = value.title
                exists.status = value.status
                data.selected_stocks.push(exists);
            } else {
                data.selected_stocks.push({
                    quantity: 0,
                    reserved_quantity: 0,
                    inventory_id: value.id,
                    inventory_title: value.title,
                    status: value.status
                });
            }
        });
    } else {
        let def = getDifference(oldValue, newValue)
        _.remove(data.selected_stocks, {inventory_id: def[0]});
    }
})

const getDifference = (newValue, oldValue) => {
    return _.difference(_.values(newValue), _.values(oldValue))
}

const setSelectedInventoriesAndIds = () => {
   if (props.selectedInventories.length > 0) {
        _.forEach(props.selectedInventories, function (item) {
            if (item.inventory_id != null) {
                data.selected_ids.push(item.inventory_id)
            }
        });
    }
}


watch(() => [...data.selected_stocks], (newValue) => {
    if (data.is_dirty){
        emit('inventoryInputs', newValue)
    }
    data.is_dirty = true
},{deep:true})
</script>
