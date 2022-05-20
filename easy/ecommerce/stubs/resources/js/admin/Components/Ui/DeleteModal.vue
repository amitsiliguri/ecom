<template>
    <link-button @click="confirmDeletion(true)" type="button" class="mr-2">
        <i class="mdi mdi-delete-outline" aria-hidden="true"></i>
    </link-button>

    <confirmation-modal :show="deleteItem.confirmingDeletion" @close="confirmDeletion(false)">
        <template #title>
            {{ title }}
        </template>

        <template #content>
            {{ description }}
        </template>

        <template #footer>
            <secondary-button @click="confirmDeletion(false)">
                Cancel
            </secondary-button>

            <danger-button class="ml-2" @click="deleteItemById()" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                <i class="mdi mdi-delete-outline" aria-hidden="true"></i> Delete
            </danger-button>
        </template>
    </confirmation-modal>
</template>

<script setup>
import {reactive} from "vue";
import {useForm} from '@inertiajs/inertia-vue3'
import LinkButton from '@/admin/Components/Form/LinkButton.vue'
import DangerButton from '@/admin/Components/Form/DangerButton.vue'
import SecondaryButton from '@/admin/Components/Form/SecondaryButton.vue'
import ConfirmationModal from '@/admin/Components/Ui/ConfirmationModal.vue'

const props = defineProps({
    id: {
        type: Number,
        required: true
    },
    title: {
        type: String,
        required: false,
        default() {
            return 'Delete'
        }
    },
    description : {
        type: String,
        required: false,
        default() {
            return 'Are you sure you want to delete this item? Once this item is deleted, all of its resources and data will be permanently deleted.'
        }
    },
    url: {
        type: String,
        required: true
    },
})

const deleteItem = reactive({confirmingDeletion: false})

const form = useForm({})

const confirmDeletion = (value) => {
    deleteItem.confirmingDeletion = value
}

const deleteItemById = () => {
    form.delete(route(props.url, props.id),
    {
             onSuccess: () => {
                 confirmDeletion(false)
                 form.reset()
            }
    });
}
</script>
