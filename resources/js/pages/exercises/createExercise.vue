<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import {BodyPart, type BreadcrumbItem, Exercise} from '@/types';
import {Head, Link, useForm, usePage} from '@inertiajs/vue3';
import body_partsSelector from "@/components/body_partsSelector.vue";
import {FloatLabel, InputText, MultiSelect, Textarea, FileUpload, Select} from "primevue";
import {RippleButton} from "@/components/ui/ripple-button";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Exercises',
        href: route('exercises.create'),
    },
];

const units= [
    'seconds',
    'reps'
]

const page = usePage();

const body_parts = page.props.body_parts as BodyPart[]


const form  = useForm({
    body_parts: [],
    name: '',
    description: '',
    images : [],
    videos : [],
    unit: 'reps'
})


const submit_form = () => {
    form.post(route('exercises.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
        }
    });
}
</script>

<template>
    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h3 class="text-3xl mt-4 ">Create Exercise</h3>
            <form  @submit.prevent="submit_form" class="grid w-full grid-cols-3 gap-x-4 gap-y-12 rounded-xl my-12">

                <FloatLabel class="col-span-1">
                    <InputText required class="w-full" id="name" v-model="form.name" />
                    <label for="name">Name *</label>
                </FloatLabel>


                <FloatLabel class="col-span-1">
                    <MultiSelect
                        display="chip"
                        class="w-full"
                        :options="body_parts"
                        v-model="form.body_parts"
                        filter
                        auto-filter-focus
                        :max-selected-labels="3"
                        show-clear
                        :multiple="true"
                        option-label="name"
                        option-value="id"
                        />
                    <label for="name">Body Parts</label>
                </FloatLabel>

                <FloatLabel class="col-span-1 col-start-1" >
                    <Select
                        class="w-full"
                        :options="units"
                        v-model="form.unit"
                        filter
                        show-clear
                        required
                        />
                    <label for="name">Unit *</label>
                </FloatLabel>

                <FloatLabel class="col-start-1 col-span-2">
                    <Textarea
                        class="w-full"
                        rows="5"
                        v-model="form.description"
                        auto-resize
                    />
                    <label for="name">Description</label>
                </FloatLabel>


                <div class="start-col-1 col-span-2 space-y-4">
                    <h2 class="text-xl"> Images </h2>
                    <FileUpload
                        :show-upload-button="false "
                        :show-cancel-button="false"
                        v-model="form.images"
                        @input="form.images.push($event.target.files[0])"
                        @remove="form.images = form.images.filter(item => item.objectURL !== $event.file.objectURL);"
                        :multiple="true"
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
                </div>


                <div class="start-col-1 col-span-2 space-y-4">
                    <h2 class="text-xl"> Videos </h2>
                    <FileUpload
                        :show-upload-button="false "
                        :show-cancel-button="false"
                        :multiple="true"
                        @input="form.videos.push($event.target.files[0])"
                        @remove="form.videos = form.videos.filter(item => item.objectURL !== $event.file.objectURL);"
                        accept="video/*"
                        :maxFileSize="10000000"
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
                </div>


                <RippleButton class="col-start-1 w-32"  type="submit"> Submit </RippleButton>

        </form>


    </AppLayout>
</template>
