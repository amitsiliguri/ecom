<template>
    <link-button v-if="children === 0" @click="confirmDeletion" type="button" class="mr-2">
        <i class="mdi mdi-delete-outline" aria-hidden="true"></i>
    </link-button>

    <confirmation-modal :show="confirmingDeletion" @close="confirmingDeletion = false">
        <template #title>
            Delete
        </template>

        <template #content>
            Are you sure you want to delete this item? Once a item is deleted, all of its resources and data will be permanently deleted.
        </template>

        <template #footer>
            <secondary-button @click="confirmingDeletion = false">
                Cancel
            </secondary-button>

            <danger-button class="ml-2" @click="deleteItem" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                <i class="mdi mdi-delete-outline" aria-hidden="true"></i> Delete
            </danger-button>
        </template>
    </confirmation-modal>

    <Link :link="route(editRoute, elementId)">
        <i class="mdi mdi-pencil" aria-hidden="true"></i>
    </Link>
</template>

<script>
import Link from '@/admin/Components/Link.vue'
import LinkButton from '@/admin/Components/Form/LinkButton.vue'
import DangerButton from '@/admin/Components/Form/DangerButton.vue'
import SecondaryButton from '@/admin/Components/Form/SecondaryButton.vue'
import ConfirmationModal from '@/admin/Components/Ui/ConfirmationModal.vue'

export default {
    name: "TreeAction",
    props: {
        editRoute: {
            required: true,
            type: String
        },
        deleteRoute: {
            required: true,
            type: String
        },
        elementId: {
            required: true,
            type: Number
        },
        children : {
            required: true,
            type: Number
        }
    },
    components: {
        Link,
        LinkButton,
        ConfirmationModal,
        DangerButton,
        SecondaryButton
    },
    data() {
        return {
            confirmingDeletion : false,
            deleting: false,
            form: this.$inertia.form()
        }
    },
    methods: {
        confirmDeletion() {
            this.confirmingDeletion = true
        },
        deleteItem() {
            this.form.delete(route(this.deleteRoute, this.elementId));
        },
    }
};
</script>
