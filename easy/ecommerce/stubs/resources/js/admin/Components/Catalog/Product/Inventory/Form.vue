<template>
    <easy-form-section @submitted="submit()">
        <template #title>
            {{ formMode }} Inventory Form
        </template>
        <template #description>
            Fill up all the required details to {{ formMode }} inventory.
        </template>
        <template #form>
            <easy-check-box label="Is Category Active?" id="status" v-model:checked="form.status" :error="form.errors.status"/>
            <easy-input label="Title" id="title" type="text" v-model="form.title" autofocus :error="form.errors.title"/>
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
import { computed } from 'vue'
import {useForm} from '@inertiajs/inertia-vue3'
import EasyActionMessage from "@/admin/Components/Form/ActionMessage.vue";
import EasyInput from "@/admin/Components/Form/Input.vue";
import EasyButton from "@/admin/Components/Form/Button.vue";
import EasyFormSection from "@/admin/Components/Form/FormSection.vue";
import EasyCheckBox from "@/admin/Components/Form/Checkbox";

const props = defineProps({
    formData: {
        type: Object,
        required: false,
        default() {
            return {
                id: null,
                status: true,
                title: "",
                created_at: "",
                updated_at: ""
            }
        }
    },
})

const formMode = computed(() => (props.formData.id) ? 'Edit' : 'Create');

const form = useForm({
    _method: (props.formData.id) ? 'PUT' : 'POST',
    id: (props.formData.id) ? props.formData.id : null,
    status: Boolean(props.formData.status),
    title: props.formData.title
})

function submit() {
    let url = (form.id) ? route('admin.catalog.category.update', form.id) : route('admin.catalog.category.store');
    form.transform((data) => ({
        ...data,
        status: (data.status) ? 1 : 0,
    })).post(url,{
        errorBag: 'catalogProductInventory',
        onSuccess: () => {
            form.reset()
        }
    })
}
</script>
