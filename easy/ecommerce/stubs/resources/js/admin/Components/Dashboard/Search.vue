<template>
    <form @submit.prevent="submit" class="w-80 mr-2 mb-1">
        <BreezeInput id="email" type="email" class="mt-1 block w-full" required placeholder="Search"/>
    </form>
</template>

<script>
import BreezeInput from '@/admin/Components/Form/Input'

export default {
    name: "Search",
    components: {
        BreezeInput
    },
    methods: {
        submit() {
            console.log('submitted');
        }
    }
}
</script>
