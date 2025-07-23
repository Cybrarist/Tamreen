<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import {BodyPart, type BreadcrumbItem, Exercise} from '@/types';
import {Head, Link, usePage} from '@inertiajs/vue3';
import {GlareCard} from "@/components/ui/glare-card";
import {RippleButton} from "@/components/ui/ripple-button";
import {VanishingInput} from "@/components/ui/vanishing-input";
import {computed, ref} from "vue";
import {HoverCard, HoverCardTrigger, HoverCardContent} from "@/components/ui/hover-card";
import {ExerciseCard} from "@/components/ui/exercise-card";
import CreateExercise from "@/components/forms/exercises/CreateExercise.vue";
import {Button} from "primevue";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Exercises',
        href: '/exercises',
    },
];

const page = usePage();

const body_parts = page.props.body_parts as BodyPart[]
const exercises = page.props.exercises as Exercise[]

const search  = ref<string>('');

const placeholders = computed(()=>{
    return exercises.map(item => item.name)
})


const filterExercises = (body_parts: BodyPart[]) => {
    console.log(body_parts)
}


</script>

<template>
    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="w-full flex justify-between">
                <div class="w-full md:w-1/3 flex flex-row">
                    <VanishingInput
                        class="w-full"
                        v-model="search"
                        :placeholders="placeholders"
                    />
                </div>
                <Link :href="route('exercises.create')">
                    <Button size="small" label="Add Exercise" icon="pi pi-plus" />
                </Link>

            </div>
<!--            <div class="w-1/3">-->
<!--                <BodyPartsFilter :body-parts="bodyParts" @filtered="filterExercises" />-->
<!--            </div>-->
            <div class="grid auto-rows-min gap-4 md:grid-cols-6 grid-cols-2" v-if="body_parts.length">
                <Link :key="item.id" v-for="item in exercises"
                      :href="route('exercises.show', item.id)" >
                    <ExerciseCard>
                        <div class="w-full h-full flex justify-center items-center">
                            <h3 class="z-20 text-2xl font-bold text-primary-foreground text-center px-2">{{item.name}}</h3>

                            <img :src="'/storage/exercises/' + ((item.images?.length) ? item.images[0] : 'abs.jpg')"
                                 class="object-cover h-full w-full absolute z-10 opacity-50"
                             :alt="item.name"/>
                        </div>
                    </ExerciseCard>

                </Link>
            </div>
            <div v-else>
                No Items Found
            </div>
        </div>


    </AppLayout>
</template>
