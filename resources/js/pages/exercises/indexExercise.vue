<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import {BodyPart, type BreadcrumbItem, Exercise, Item} from '@/types';
import {Head, Link, router, usePage} from '@inertiajs/vue3';
import {VanishingInput} from "@/components/ui/vanishing-input";
import {computed, ref} from "vue";
import {ExerciseCard} from "@/components/ui/exercise-card";
import {Button} from "primevue";
import {useDebounceFn} from "@vueuse/core";
import Pagination from "@/components/Pagination.vue";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Exercises',
        href: route('exercises.index'),
    },
];

const page = usePage();

const body_parts = page.props.body_parts as BodyPart[]
const exercises = ref<Exercise[]>(page.props.exercises as Exercise[])

const search  = ref<string>(page.props.search);

const placeholders = computed(()=>{
    return exercises.value.data.map(exercise => exercise.name)
})


const debouncedSearch = useDebounceFn(async () => {
    router.get(route('exercises.index'), {
        search: search.value,
    },{
        preserveScroll: true,
        preserveState: false,
    })
}, 500)


</script>

<template>
    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div  class="flex h-fit overflow-auto flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="w-full flex justify-between sticky">
                <div class="w-full flex justify-between items-center">
                    <VanishingInput
                            class="w-3/5 sm:w-2/3 lg:w-1/3"
                            v-model="search"
                            @change="debouncedSearch"
                            :placeholders="placeholders"
                        />
                    <Link class="w-fit" :href="route('exercises.create')">
                        <Button size="small" label="Add Exercise" icon="pi pi-plus" />
                    </Link>

                </div>
            </div>
<!--            <div class="w-1/3">-->
<!--                <BodyPartsFilter :body-parts="bodyParts" @filtered="filterExercises" />-->
<!--            </div>-->
            <div class="grid grid-cols-2 z-20 sm:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-4" v-if="body_parts.length">
                <Link :key="exercise.id" v-for="exercise in exercises.data"
                      :href="route('exercises.show', exercise.id)"
                >
                    <ExerciseCard>
                        <div class="w-full h-full flex justify-center items-center">
                            <h3 class="z-20 text-2xl font-bold text-primary text-center px-2">{{exercise.name}}</h3>

                            <img :src="'/storage/exercises/' + ((exercise.images?.length) ? exercise.images[0] : 'exercise.png')"
                                 class="object-cover h-full w-full absolute z-10 opacity-50"
                             :alt="exercise.name"/>
                        </div>
                    </ExerciseCard>

                </Link>

                <Pagination class="col-span-full" :next-link="exercises.next_page_url" :prev-link="exercises.prev_page_url" />

            </div>
            <div v-else>
                No Items Found
            </div>
        </div>


    </AppLayout>
</template>
