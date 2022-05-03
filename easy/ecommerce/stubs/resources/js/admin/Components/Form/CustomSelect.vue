<template>
    <div>
        <template v-if="label">
            <easy-label :for="id" :value="label"/>
        </template>

        <div class="select-cover relative" :class="{ 'overflow-hidden': !showOptions }" ref="customSelect">
            <div class=" mt-1 p-2 block w-full bg-white border-gray-300 shadow-sm cursor-pointer selected" :style="selectedStyle" @click="showOptions = !showOptions" >
                <template v-if="selected.length">

<!--                    <span v-for="(item, index) in selected" :key="index" class="bg-gray-100 py-1 px-2 mx-1 rounded-full">-->
<!--                        {{ item.label }}-->
<!--                    </span>-->
                    {{ selected.length }} item selected
                </template>
                <template v-else>
                    <span> {{ placeholder }} </span>
                </template>
            </div>
            <div v-show="showOptions" class="fixed inset-0 z-40" @click="showOptions = false"></div>
            <ul class=" options absolute bg-white w-full rounded-bl-md rounded-br-md border-gray-300 overflow-y-auto max-h-40 z-50" :class="{ invisible: !showOptions }" :style="dropDownStyle" ref="customDropDown">
                <template v-if="optionData.length">
                    <li v-for="(option, index) in optionData" :key="index"  class="cursor-pointer px-2 py-1 hover:bg-gray-100" @click="toggleOption(option)" >
                        {{ option.label }}
                    </li>
                </template>
                <li v-else class="cursor-pointer px-2 py-1 hover:bg-gray-100">
                    No options available for now.
                </li>
            </ul>
        </div>

    </div>
</template>


<script setup>
import {onMounted, reactive, ref, watch} from "vue";
import EasyLabel from "@/admin/Components/Form/Label.vue";
// import EasyInputError from "@/admin/Components/Form/InputError.vue";

const props = defineProps({
    modelValue: Array,
    id: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: false
    },
    placeholder: {
        type: String,
        required: true
    },
    multiple: {
        type: Boolean,
        required: false,
        default () {
            return false
        }
    },
    options: {
        type: Array,
        required: true
    },
    mapKeys: {
        type: Object,
        required: false,
        default () {
            return [
                {
                    value: 'value',
                    label: 'label'
                }
            ]
        }
    }
})

const emit = defineEmits(['update:modelValue'])

const customSelect = ref(null);
const customDropDown = ref(null);

let multiple = ref(false)
let showOptions = ref(false)
let selected = ref([])

let optionData = reactive([])
let dropDownStyle = reactive({
    marginTop: "0px",
    boxShadow: "0px 9px 10px 0px rgba(0,0,0,0.1)",
    borderWidth: "0px 1px 1px 1px",
    borderRadius: "0px 0px 6px 6px",
})
let selectedStyle = reactive({
    borderRadius: "6px 6px 6px 6px",
    borderWidth: "1px"
})

onMounted(() => {
    mapOptions()
    selected.value = props.modelValue;
    multiple.value = props.multiple;
})

const mapOptions = () => {
    props.options.forEach((item) => {
        optionData.push({
            value: mapping(item, 'value'),
            label: mapping(item, 'label'),
        })
    })
}

const mapping = (item, key) => {
    return (item.hasOwnProperty(key)) ? item[key] : item[props.mapKeys[key]]
}

watch(showOptions, (val) => {
    if (val) {
        let bottomPosition = customSelect.value.getBoundingClientRect().bottom;
        let topPosition = customSelect.value.getBoundingClientRect().top;
        let screenHeight = window.innerHeight;
        let dropDownHeight = customDropDown.value.clientHeight;
        if (screenHeight - bottomPosition < dropDownHeight) {
            dropDownStyle.marginTop = - (dropDownHeight + 1 + (bottomPosition - topPosition) - 4) + "px";
            dropDownStyle.boxShadow = "0px -10px 10px 0px rgba(0,0,0,0.1)";
            dropDownStyle.borderRadius = "6px 6px 0px 0px";
            dropDownStyle.borderWidth = "1px 1px 0px 1px";
            selectedStyle.borderRadius = "0px 0px 6px 6px";
        } else {
            selectedStyle.borderRadius = "6px 6px 0px 0px";
        }
    } else {
        dropDownStyle.marginTop = "0px";
        dropDownStyle.boxShadow = "0px 9px 10px 0px rgba(0,0,0,0.1)";
        dropDownStyle.borderRadius = "0px 0px 6px 6px";
        dropDownStyle.borderWidth = "0px 1px 1px 1px";
        selectedStyle.borderRadius = "6px 6px 6px 6px";
    }
})

const toggleOption = (option) => {
    let indexId = isAlreadySelected(option);
    if (indexId > -1) {
        selected.value.splice(indexId, 1);
    } else {
        if (multiple.value) {
            selected.value.push(option.value);
        } else {
            selected.value[0] = option.value;
        }
    }
    showOptions.value = !!(multiple.value);
    emit('update:modelValue', selected.value)
}

const isAlreadySelected = (option) => {
    let key = -1;
    if (selected.value.length) {
        selected.value.forEach((element, index) => {
            if (option.value == element) {
                key = index;
            }
        });
    }
    return key;
}

</script>
