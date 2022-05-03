<template>
    <div v-if="hasErrors">
        <div class="font-medium text-red-600">Whoops! Something went wrong.</div>
    </div>
</template>

<script>
export default {
    computed: {
        errors() {
            return this.$page.props.errors
        },
        hasErrors() {
            return Object.keys(this.errors).length > 0
        },
    }
}
</script>
