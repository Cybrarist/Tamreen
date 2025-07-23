<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import {BodyPart, type BreadcrumbItem, Exercise, Item, Workout} from '@/types';
import {Head, Link, router, usePage} from '@inertiajs/vue3';
import WorkoutCard from "@/components/WorkoutCard.vue";
import {useDebounceFn} from "@vueuse/core";
import axios from "axios";
import {ref} from "vue";
import {RippleButton} from "@/components/ui/ripple-button";
import CompleteWorkoutCard from "@/components/CompleteWorkoutCard.vue";
import GridWorkoutCard from "@/components/GridWorkoutCard.vue";
import RecordExerciseCard from "@/components/ui/record-exercise-card/RecordExerciseCard.vue";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Workouts',
        href: route('workouts.index'),
    },
];

const page = usePage();

const workout = page.props.workout as Workout
const hotkeys = [
    'q','w','e','r',
    'a','s','d','f',
    'z','x','c','v',
]

const completing = ref(false)

const debouncedUpdate = useDebounceFn(async () => {
    console.log(workout.exercises)
    await axios.put(route('workouts.update', workout.id), {
        exercises: workout.exercises.map(exercise => {
            return {
                id: exercise.id,
                multiplier: exercise.pivot.multiplier,
                count: exercise.pivot.count,
                completed: exercise.pivot.completed,
            }
        }),
    })

    router.reload()
}, 1000)
</script>

<template>
    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="w-full flex  justify-end">
                <RippleButton v-if="!completing" @click="completing=true" class="bg-green-600">Start Working</RippleButton>
                <RippleButton v-if="completing" @click="completing=false" class="bg-red-500">Continue Recording</RippleButton>
            </div>
            <div class="grid auto-rows-min gap-4 md:grid-cols-4" v-if="workout.exercises?.length && !completing">
                <WorkoutCard :key="exercise.id"
                             v-for="(exercise, index) in workout.exercises"
                             :hotkey="hotkeys[index]"
                             :exercise="exercise"
                             @exercise-updated="debouncedUpdate"
                />

            </div>

            <div class="grid auto-rows-min gap-4 md:grid-cols-4 0" v-else-if="workout.exercises?.length && completing">
                <CompleteWorkoutCard
                            :key="exercise.id"
                             v-for="(exercise, index) in workout.exercises"
                             :hotkey="hotkeys[index]"
                             :exercise="exercise"
                             @exercise-updated="debouncedUpdate"
                />
            </div>

            <div v-else>
                No Items Found
            </div>
        </div>


    </AppLayout>
</template>
