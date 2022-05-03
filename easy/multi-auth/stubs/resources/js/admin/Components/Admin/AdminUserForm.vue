<template>
    <form @submit.prevent="submit">
        <div v-if="canChangeInput()">
            {{form.active}}
            <EasyLabel for="active" value="active"/>
            <input type="checkbox" v-model="form.active" id="active">
            <easy-input-error :message="form.errors.active"/>
        </div>
        <div>
            <EasyLabel for="name" value="Name"/>
            <EasyInput
                id="name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.name"
                required
                autofocus
                autocomplete="name"
            />
            <easy-input-error :message="form.errors.name"/>
        </div>

        <div class="mt-4">
            <EasyLabel for="email" value="Email"/>
            <EasyInput
                id="email"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
                required
                autocomplete="username"
            />
            <easy-input-error :message="form.errors.email"/>
        </div>

        <div class="mt-4">
            <EasyLabel for="password" value="Password"/>
            <EasyInput
                id="password"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password"
                :required="!form.id"
                autocomplete="new-password"
            />
            <easy-input-error :message="form.errors.password"/>
        </div>

        <div class="mt-4">
            <EasyLabel for="password_confirmation" value="Confirm Password"/>
            <EasyInput
                id="password_confirmation"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password_confirmation"
                :required="!form.id"
                autocomplete="new-password"
            />
            <easy-input-error :message="form.errors.password_confirmation"/>
        </div>

        <div class="flex items-center justify-end mt-4">

            <EasyButton
                class="ml-4"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Register
            </EasyButton>
        </div>
    </form>
</template>

<script setup>

import { useForm, usePage } from '@inertiajs/inertia-vue3'
import EasyInput from "@/admin/Components/Form/Input.vue";
import EasyInputError from "@/admin/Components/Form/InputError.vue";
import EasyLabel from "@/admin/Components/Form/Label.vue";
import EasyButton from "@/admin/Components/Form/Button.vue";

const props = defineProps({
    formData: {
        type: Object,
        required: false,
        default() {
            return {
                id: null,
                active: true,
                name: "",
                email: "",
                email_verified_at: "",
                created_at: "",
                updated_at:""
            }
        }
    },
})

const form = useForm({
    id: props.formData.id,
    active: Boolean(props.formData.active),
    name: props.formData.name,
    email: props.formData.email,
    password: "",
    terms: "",
    password_confirmation: ""
})

function canChangeInput() {
    return (!(props.formData.id && props.formData.id === usePage().props.value.auth.user.id));
}

function submit() {
    if (form.id) {
        form._method = 'put'
        form.put(route('admin.users.update', form.id), {
            errorBag: 'adminsRegistrationError',
            onSuccess: () => form.reset(),
        });
    } else {
        form.post(route("admin.register"), {
            errorBag: 'adminsRegistrationError',
            onSuccess: () => form.reset()
        });
    }
}
</script>
