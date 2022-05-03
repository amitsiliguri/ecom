<template>
    <form @submit.prevent="$emit('submitted')">
        <card separator>
            <template #header>
                <easy-section-title>
                    <template #title><slot name="title"></slot></template>
                    <template #description><slot name="description"></slot></template>
                </easy-section-title>
            </template>
            <div class="flex flex-col p-2">
                <slot name="form"></slot>
            </div>
            <template #footer>
                <slot name="actions"></slot>
            </template>
        </card>
    </form>
</template>

<script setup>
import EasySectionTitle from '@/admin/Components/Form/SectionTitle.vue'
import Card from "@/admin/Components/Ui/Card";
</script>
