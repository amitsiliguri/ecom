<template>
    <div class="w-full bg-white shadow-sm rounded" :class="{'h-full':fullHeight}">
        <div v-if="$slots.header" class="p-3" :class="{'border-b border-gray-200' :separator}">
            <slot name="header"/>
        </div>
        <slot/>
        <div v-if="$slots.footer" class="p-3" :class="{'border-t border-gray-200' :separator}">
            <slot name="footer"/>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    separator: {
        type: Boolean,
        required: false,
        default: false
    },
    fullHeight: {
        type: Boolean,
        required: false,
        default: false
    }
})
</script>
