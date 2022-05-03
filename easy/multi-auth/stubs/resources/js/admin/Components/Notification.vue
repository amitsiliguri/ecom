<template>
    <div v-if="message" :class="style" class="py-2 px-3 mb-4 flex items-center justify-between flex-wrap">
        <p class="ml-3 font-medium text-sm text-white truncate">
            {{ message }}
        </p>
        <button
            type="button"
            class="-mr-1 flex p-2 rounded-md focus:outline-none sm:-mr-2 transition"
            aria-label="Dismiss"
            @click.prevent="message = null">
            <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</template>

<script setup>

import { ref, watch, onMounted } from 'vue'

let message = ref(null)
let style = ref(null)

const props = defineProps({
    flash: {
        type: Object,
        required: false,
        default() {
            return { "success": null, "error": null, "warning": null }
        }
    },
})

watch(() => props.flash, (newValue, oldValue) => {
        updateMessage(newValue)
    },
    { deep: true }
)

onMounted(() => {
    updateMessage(props.flash)
})

const updateMessage = (value) => {
    if (value.success) {
        message.value = value.success
        style.value = 'bg-indigo-500'
    } else if (value.error) {
        message.value = value.error
        style.value = 'bg-red-500'
    } else if (value.warning) {
        message.value = value.warning
        style.value = 'bg-yellow-500'
    }
}
</script>
