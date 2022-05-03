<template>
    <slot name="expansionHeader"></slot>
    <div class="w-full duration-100 relative overflow-hidden"
         :style="expansionBodyStyle">
        <div ref="innerBody">
            <slot name="expansionContent">Default content</slot>
        </div>
    </div>
</template>

<script setup>
import {onMounted, onUnmounted, reactive, ref, watch} from "vue";

const props = defineProps({
    open: {
        type: Object,
        required: true,
        default: {
            open: false
        }
    }
})

let expansionBodyHeight = 0

let expansionBodyStyle = reactive({})

const innerBody = ref(null)

onMounted(() => {
    detectHeight()
    window.addEventListener("resize", detectHeight);
})

onUnmounted(() => {
    window.removeEventListener("resize", detectHeight);
})

watch(props.open, (newValue) => {
    setHeight(newValue.open)
})

const detectHeight = () => {
    expansionBodyHeight = innerBody.value.clientHeight;
    setHeight(props.open.open)
}

const setHeight = (isAllowed) => {
    expansionBodyStyle.height = (isAllowed) ? expansionBodyHeight + 'px' : 0 + 'px'
}
</script>
