<template>
    <button :type="type" class="inline-flex items-center p-0 border border-transparent font-semibold uppercase">
        <slot />
    </button>
</template>

<script>
export default {
    props: {
        type: {
            type: String,
            default: 'submit',
        },
    }
}
</script>
