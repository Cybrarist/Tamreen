<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem} from '@/types';
import {Head, useForm, usePage} from '@inertiajs/vue3';
import {FloatLabel, InputText, Textarea, FileUpload, Select} from "primevue";
import {RippleButton} from "@/components/ui/ripple-button";
import InputError from "@/components/InputError.vue";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Exercises',
        href: route('exercises.create'),
    },
];


const page = usePage();

const types = page.props.types

const form  = useForm({
    name: '',
    image : null,
    description: '',
    type_id:null,
})

const submit_form = () => {
    form.post(route('items.store'), {
        preserveScroll: true,
    });
}

</script>

<template>
    <Head title="Create Item" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h3 class="text-3xl mt-4 ">Create Item</h3>
            <form  @submit.prevent="submit_form"
                   class="w-full grid  grid-cols-1 sm:grid-cols-3 gap-x-4 gap-y-6 sm:gap-y-12 rounded-xl my-12">

                <div class="col-span-full sm:col-span-1">
                    <FloatLabel>
                        <InputText fluid id="name" v-model="form.name" />
                        <label for="name">Name</label>

                    </FloatLabel>
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="col-span-full sm:col-span-1">
                    <FloatLabel>
                        <Select
                            fluid
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


                <div class="col-span-full sm:col-start-1 sm:col-span-2">
                    <FloatLabel>
                    <Textarea
                        fluid
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
                        @input="form.image = $event.target.files[0]"
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


    </AppLayout>
</template>
