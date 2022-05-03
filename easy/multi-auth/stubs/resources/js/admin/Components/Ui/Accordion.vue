<template>
    <div v-if="props.data.length" class="bg-white shadow rounded">
        <template v-for="(expansion,index) in accordionData" :key="index">
            <expansion-panel :open="expansion">
                <template v-slot:expansionHeader>
                    <div @click="toggleExpansion(index)" class="px-4 py-2 w-full cursor-pointer">
                        <h3 class="text-lg">{{ expansion.title }}</h3>
                    </div>
                </template>
                <template v-slot:expansionContent>
                    <div  class="px-4 py-2 border-b border-gray-200">
                        {{ expansion.content }}
                    </div>
                </template>
            </expansion-panel>
        </template>
    </div>
</template>

<script setup>
import {reactive} from "vue";
import ExpansionPanel from "@/admin/Components/Ui/ExpansionPanel";

const props = defineProps({
    data: {
        type: Array,
        required: true,
        default: [{
            title: "",
            content: "",
            open: false
        }]
    },
    single: {
        type: Boolean,
        required: false,
        default: false
    }
})

const accordionData = reactive(props.data)

const toggleExpansion = (index) => {
    accordionData[index].open = !accordionData[index].open
    if (props.single) {
        _.forEach(accordionData, function (value, key) {
            if (key != index && value.open === true) {
                accordionData[key].open = false
            }
        });
    }
}
</script>
