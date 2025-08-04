<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import {BodyPart, type BreadcrumbItem, Exercise} from '@/types';
import {Head, Link, router, useForm, usePage} from '@inertiajs/vue3';
import {FloatLabel, InputText, MultiSelect, Textarea, FileUpload, Select} from "primevue";
import {RippleButton} from "@/components/ui/ripple-button";
import {computed, onMounted, ref} from "vue";
import {Carousel, Image, Button} from 'primevue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Exercises',
        href: route('exercises.index'),
    },
];

const units= [
    'seconds',
    'reps'
]

const page = usePage();

const body_parts = page.props.body_parts as BodyPart[]
const exercise = computed(()=> page.props.exercise as Exercise)

const form  = useForm({
    body_parts: [],
    name: '',
    description: '',
    images : [],
    videos : [],
    unit: '',
    deleted_images: [],
    deleted_videos: []
})

onMounted(()=>{
    form.body_parts = exercise.value.body_parts.map((part) => part.id)
    form.name = exercise.value.name
    form.description = exercise.value.description
    form.unit = exercise.value.unit
})


const submit_form = () => {

    router.post(route('exercises.update', exercise.value.id), {
        forceFormData: true,
        _method: 'PUT',
        ...form.data(),
    })
}

const responsiveOptions = ref([
    {
        breakpoint: '1400px',
        numVisible: 2,
        numScroll: 1
    },
    {
        breakpoint: '1199px',
        numVisible: 3,
        numScroll: 1
    },
    {
        breakpoint: '767px',
        numVisible: 2,
        numScroll: 1
    },
    {
        breakpoint: '575px',
        numVisible: 1,
        numScroll: 1
    }
]);

const delete_image = (image: string) => {
    form.deleted_images.push(image)
    exercise.value.images = exercise.value.images.filter(item => item !== image)
}

const delete_video = (video: string) => {
    form.deleted_videos.push(video)
    exercise.value.videos = exercise.videos.filter(item => item !== video)
}
</script>

<template>
    <Head :title="`Edit ${exercise.name}`" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-fit overflow-auto flex-1 flex-col gap-4 rounded-xl p-4">


            <h3 class="text-3xl mt-4 ">Edit {{ exercise.name }}</h3>
            <form  @submit.prevent="submit_form" class="grid w-full grid-cols-3 gap-x-4 gap-y-12 rounded-xl my-12">

                <FloatLabel class="col-span-full md:col-span-1">
                    <InputText required fluid id="name" v-model="form.name" />
                    <label for="name">Name</label>
                </FloatLabel>

                <FloatLabel class="col-span-full md:col-span-1">
                    <MultiSelect
                        fluid
                        display="chip"
                        :options="body_parts"
                        v-model="form.body_parts"
                        filter
                        :max-selected-labels="3"
                        show-clear
                        :multiple="true"
                        option-label="name"
                        option-value="id"
                        />
                    <label for="name">Body Parts</label>
                </FloatLabel>

                <FloatLabel class="col-span-full md:col-start-1 md:col-span-1" >
                    <Select
                        fluid
                        :options="units"
                        v-model="form.unit"
                        filter
                        show-clear
                        />
                    <label for="name">Unit</label>
                </FloatLabel>

                <FloatLabel class="col-span-full md:col-start-1 md:col-span-2">
                    <Textarea
                        fluid
                        rows="5"
                        v-model="form.description"
                        auto-resize
                    />
                    <label for="name">Description</label>
                </FloatLabel>


                <div class="start-col-1 col-span-full md:col-span-2 space-y-4">
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

                <div class="col-span-full md:col-span-2 col-start-1">
                    <Carousel :show-navigators="false" show-indicators
                              :value="exercise.images"
                              :responsive-options="responsiveOptions" :numVisible="3" :numScroll="1"
                              circular :autoplayInterval="3000">
                        <template #item="slotProps">
                            <div class="rounded-2xl  m-2 mx-auto max-h-32  md:max-w-72 relative">
                                <Button rounded size="small" severity="danger" icon="pi pi-trash"
                                        raised
                                        class="float-right absolute! right-4 top-4 z-10"
                                    @click="delete_image(slotProps.data)"
                                />
                                <Image :src="'/storage/exercises/' + slotProps.data" class="m-auto" preview
                                    :pt="{
                                    root:{
                                        class:'w-full'
                                    },
                                    image:{
                                        class: 'rounded-lg  mx-auto max-h-32 '
                                    }
                                    }"
                                />
                            </div>
                        </template>
                    </Carousel>

                </div>



                <div class="start-col-1 col-span-full md:col-span-2 space-y-4">
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

                <div class="col-span-full md:col-span-2  col-start-1">
                    <Carousel :show-navigators="false" show-indicators   :value="exercise.videos"
                              :responsive-options="responsiveOptions" :numVisible="3" :numScroll="1"
                              circular :autoplayInterval="3000">
                        <template #item="slotProps">
                            <div class="rounded-2xl w-full mx-auto m-2  max-w-72 relative">
                                <Button rounded size="small" severity="danger" icon="pi pi-trash"
                                        raised
                                        class="float-right absolute! right-4 top-4 z-10"
                                        @click="delete_video(slotProps.data)"
                                />

                                <video :src="'/storage/exercises/' + slotProps.data"
                                       muted controls

                                    class="rounded-lg mx-auto w-full"
                                />
                            </div>
                        </template>
                    </Carousel>

                </div>

                <div class="col-span-full md:col-span-2">
                    <RippleButton class="col-start-1 w-32 float-right"  type="submit"> Update </RippleButton>
                </div>


        </form>

        </div>
    </AppLayout>
</template>
