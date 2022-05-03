<template>
    <easy-form-section @submitted="submit()">
        <template #title>
            Category Form
        </template>

        <template #description>
            Fill up all the required details to create/update a category.
        </template>
        <template #form>
            <easy-check-box label="Is Category Active?" id="status" v-model:checked="form.status"
                            :error="form.errors.status"/>
            <easy-input label="Title" id="title" type="text" v-model="form.title" autofocus :error="form.errors.title"/>
            <easy-file-upload label="Banner" id="banner" v-model="form.banner"/>
            <div class="block my-4">
                <EasyLabel for="description" value="Description"/>
                <editor :api-key="key" :init="initEditor()" v-model="form.description"/>
                <easy-input-error :message="form.errors.description"/>
            </div>
            <easy-input label="Slug" id="slug" type="text" v-model="form.slug" autofocus :error="form.errors.slug"/>
            <easy-input label="Meta Title" id="meta_title" type="text" v-model="form.meta_title" autofocus
                        :error="form.errors.meta_title"/>
            <easy-text-area label="Meta Description" id="meta_description" v-model="form.meta_description"
                            :error="form.errors.meta_description"/>
            <easy-file-upload label="Meta Image" id="meta_image" v-model="form.meta_image"/>
        </template>

        <template #actions>
            <div class="flex justify-between">
                <easy-action-message :on="form.recentlySuccessful" class="mr-3">
                    Saved.
                </easy-action-message>

                <easy-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Save
                </easy-button>
            </div>
        </template>
    </easy-form-section>
</template>

<script setup>
import {useForm} from '@inertiajs/inertia-vue3'
import {initTinyMCE} from '@/admin/Composable/TinyMCE.js'
import {imagePreview} from '@/admin/Composable/ImagePreview.js'
import EasyActionMessage from "@/admin/Components/Form/ActionMessage.vue";
import EasyInput from "@/admin/Components/Form/Input.vue";
import EasyInputError from "@/admin/Components/Form/InputError.vue";
import EasyLabel from "@/admin/Components/Form/Label.vue";
import EasyButton from "@/admin/Components/Form/Button.vue";
import Editor from "@tinymce/tinymce-vue";
import EasyTextArea from "@/admin/Components/Form/TextArea.vue";
import EasyFormSection from "@/admin/Components/Form/FormSection.vue";
import EasyCheckBox from "@/admin/Components/Form/Checkbox";
import EasyFileUpload from '@/admin/Components/Form/FileUpload.vue';

const {key, initEditor} = initTinyMCE();
const {getPreviewImage, constructImageObject} = imagePreview();

const props = defineProps({
    formData: {
        type: Object,
        required: false,
        default() {
            return {
                id: null,
                status: true,
                title: "",
                description: "",
                banner: [],
                slug: "",
                meta_title: "",
                meta_description: "",
                meta_image: [],
                created_at: "",
                updated_at: ""
            }
        }
    },
})

const form = useForm({
    _method: (props.formData.id) ? 'PUT' : 'POST',
    id: (props.formData.id) ? props.formData.id : null,
    status: Boolean(props.formData.status),
    title: props.formData.title,
    description: props.formData.description,
    banner: getPreviewImage(
        props.formData.id,
        props.formData.banner,
        props.formData.title
    ),
    slug: props.formData.slug,
    meta_title: props.formData.meta_title,
    meta_description: props.formData.meta_description,
    meta_image: getPreviewImage(
        props.formData.id,
        props.formData.meta_image,
        props.formData.meta_title
    ),
})

function submit() {
    let url = (form.id) ? route('admin.catalog.category.update', form.id) : route('admin.catalog.category.store');
    form.transform((data) => ({
        ...data,
        status: (data.status) ? 1 : 0,
        banner: constructImageObject(data.banner),
        meta_image: constructImageObject(data.meta_image),
    })).post(url,{
        errorBag: 'catalogCategory',
        onSuccess: () => {
            form.reset()

        }
    })
}
</script>
