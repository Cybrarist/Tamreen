<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem} from '@/types';
import {Head, router, useForm, usePage} from '@inertiajs/vue3';
import {FloatLabel, InputText, Textarea, FileUpload, Select} from "primevue";
import {RippleButton} from "@/components/ui/ripple-button";
import InputError from "@/components/InputError.vue";
import {onMounted} from "vue";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: "items",
        href: route('items.index'),
    },
];


const page = usePage();

const types = page.props.types
const item = page.props.item

const form  = useForm({
    name: '',
    image : null,
    description: '',
    type_id:null,
})

onMounted(()=>{
    form.name = item.name
    form.description = item.description
    form.type_id = item.type_id
})

const submit_form = () => {
    router.post(route('items.update', {item: item.id}), {
        _method: 'PUT',
        ...form.data(),
    });
}

</script>

<template>
    <Head :title="`Edit ${item.name}`" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-fit overflow-auto flex-1 flex-col gap-4 rounded-xl p-4">

            <h3 class="text-3xl mt-4 ">Edit Item</h3>
            <form  @submit.prevent="submit_form" class="grid w-full grid-cols-3 gap-x-4 gap-y-12 rounded-xl my-12">

                <div class="col-span-1">
                    <FloatLabel >
                        <InputText class="w-full" id="name" v-model="form.name" />
                        <label for="name">Name</label>

                    </FloatLabel>
                    <InputError class="mt-2" :message="form.errors.name" />

                </div>

                <div class="col-span-1">
                    <FloatLabel  >
                        <Select
                            class="w-full"
                            :options="types"
                            v-model="form.type_id"
                            option-value="id"
                            option-label="name"
                            filter
                            show-clear
                        />
                        <label for="name">Type</label>
                    </FloatLabel>
                    <InputError class="mt-2" :message="form.errors.type_id" />

                </div>


                <div class="col-start-1 col-span-2">
                    <FloatLabel>
                    <Textarea
                        class="w-full"
                        rows="5"
                        v-model="form.description"
                        auto-resize
                    />
                        <label for="name">Description</label>
                    </FloatLabel>
                    <InputError class="mt-2" :message="form.errors.description" />

                </div>


                <div class="start-col-1 col-span-2 space-y-4">
                    <h2 class="text-xl">Image</h2>
                    <FileUpload
                        mode="basic"
                        @input="form.image = $event.target.files[0]; console.log(form.data())"
                        accept="image/*"
                        :maxFileSize="1000000"
                        :pt="{
                            pcFileBadge: {
                               root: { class: 'hidden!' }
                            },
                            pcProgressBar: {
                               root: { class: 'hidden!' }
                            },
                        }"
                    >
                        <template #empty>
                            <span>Drag and drop files to here to upload.</span>
                        </template>
                    </FileUpload>

                    <InputError class="mt-2" :message="form.errors.image" />

                </div>


                <div class="col-span-2">
                    <RippleButton class="max-w-32 float-end" type="submit">
                        Submit
                    </RippleButton>
                </div>
        </form>

        </div>

    </AppLayout>
</template>
