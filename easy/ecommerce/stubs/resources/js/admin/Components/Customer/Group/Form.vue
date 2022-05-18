<template>
    <easy-form-section @submitted="submit()" class="mb-4">
        <template #title>
            {{ title }}
        </template>
        <template #description>
            {{ description }}
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
    title: {
        type: String,
        required: false,
        default() {
            return 'Form';
        }
    },
    description: {
        type: String,
        required: false,
        default() {
            return 'Enter required details';
        }
    }
})

const form = useForm({
    _method: (props.formData.id) ? 'PUT' : 'POST',
    id: (props.formData.id) ? props.formData.id : null,
    status: Boolean(props.formData.status),
    title: props.formData.title
})

function submit() {
    form.transform((data) => ({
        ...data,
        status: (data.status) ? 1 : 0,
    })).post(
        (form.id) ? route('admin.customer.group.update', form.id) : route('admin.customer.group.store'),
        {
            errorBag: 'customerGroup',
            onSuccess: () => {
                form.reset()
            }
        }
    )
}
</script>
