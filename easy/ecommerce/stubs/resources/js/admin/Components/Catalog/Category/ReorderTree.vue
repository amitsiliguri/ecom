<template>
    <EasyButton
        type="button"
        class="w-full mb-2"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
        @click="reorder()"
    >
        Re-order
    </EasyButton>

    <tree-view
        v-if="treeViewData.length"
        :tasks="treeViewData"
        :editRoute="editRoute"
        :deleteRoute="deleteRoute"
    />
</template>

<script setup>
import {computed, watch} from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'
import TreeView from '@/admin/Components/Catalog/Category/Tree.vue'
import EasyButton from '@/admin/Components/Form/Button.vue'

const props = defineProps({
    tree: {
        required: true,
        type: Array
    },
    editRoute: {
        required: true,
        type: String
    },
    deleteRoute: {
        required: true,
        type: String
    },
    reorderRoute: {
        required: true,
        type: String
    }
})

const form = useForm({
    treeList : []
})

const treeViewData = computed(() => {
    return props.tree
})

watch(() => treeViewData, (newValue) => {
        form.treeList = newValue
    },
    { deep: true }
)

const reorder = () => {
    form.post(route(props.reorderRoute) )
}
</script>
