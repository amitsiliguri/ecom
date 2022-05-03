<template>
    <div class="block my-4">
        <easy-label :for="id" :value="label" />
        <select :id="id" :value="modelValue" :required="required" :disabled="disabled" :class="inputClass" @change="getSelectedOption($event)" ref="select" class="w-full">
            <option disabled value="">Please select one</option>
            <template v-if="selectOptions.length">
                <option v-for="(option, index) in selectOptions" :key="index" :value="option.value">
                    {{ option.label }}
                </option>
            </template>
        </select>
        <easy-input-error v-if="error" :message="error"/>
    </div>
</template>

<script>
import EasyLabel from "@/admin/Components/Form/Label.vue";
import EasyInputError from "@/admin/Components/Form/InputError.vue";

export default {
    name: "EasySelectField",
    components:{
        EasyLabel,
        EasyInputError
    },
    props: {
        modelValue: String|Number|Array,
        options: {
            type: Array,
            required: false,
            default: [
                {
                    value: null,
                    label: 'Please Select an option'
                }
            ]
        },
        inputClass:{
            type: String,
            required: false,
            default: ''
        },
        required:{
            type: Boolean,
            required: false,
            default: false
        },
        disabled:{
            type: Boolean,
            required: false,
            default: false
        },
        label: {
            type: String,
            required: true
        },
        error: {
            type: String,
            required: false,
            default: null
        },
        id: {
            type: String,
            required: true
        },
        multiple: {
            type: Boolean,
            required: false
        },
        mapKeys: {
            type: Object,
            required: false,
            default: [
                {
                    value: 'value',
                    label: 'label'
                }
            ]
        }
    },
    emits: ['update:modelValue'],
    data() {
        return {
            selectOptions : []
        }
    },
    created() {
        this.mapOptions()
    },
    methods: {
        getSelectedOption(event){
            this.$emit('update:modelValue', event.target.value)
        },
        focus() {
            this.$refs.select.focus()
        },
        mapOptions(){
            let self = this
            self.options.forEach((item) => {
                self.selectOptions.push({
                    value : self.mapping(item, 'value'),
                    label : self.mapping(item, 'label'),
                })
            })
        },
        mapping(item, key){
            return (item.hasOwnProperty(key)) ? item[key] : item[this.mapKeys[key]]
        }
    }
}
</script>
