<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Workout} from '@/types';
import {Head, router, usePage} from '@inertiajs/vue3';
import WorkoutCard from "@/components/WorkoutCard.vue";
import {useDebounceFn} from "@vueuse/core";
import axios from "axios";
import {ref} from "vue";
import {RippleButton} from "@/components/ui/ripple-button";
import CompleteWorkoutCard from "@/components/CompleteWorkoutCard.vue";
import {useConfirm } from "primevue/useconfirm";
import ConfirmDialog from "primevue/confirmdialog";
import { Trash2, Play, Dumbbell, Check } from "lucide-vue-next";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Workouts',
        href: route('workouts.index'),
    },
];

const page = usePage();

const workout = ref(page.props.workout as Workout)
const hotkeys = [
    'q','w','e','r',
    'a','s','d','f',
    'z','x','c','v',
]

const completing = ref(false)

const update_workout = async () => {
    await axios.put(route('workouts.update', workout.value.id), {
        exercises: workout.value.exercises.map(exercise => {
            return {
                id: exercise.id,
                multiplier: exercise.pivot.multiplier,
                count: exercise.pivot.count,
                completed: exercise.pivot.completed,
            }
        }),
    })
}

const debouncedUpdate = useDebounceFn(async () => {

    await update_workout()
    workout.value.exercises.forEach(exercise => {
        exercise.pivot.total = Math.round(exercise.pivot.count * exercise.pivot.multiplier)
    })

}, 1000)

const confirm = useConfirm();
const complete_workout_confirmation = () => {
    confirm.require({
        message: 'Are you sure you want to Complete this workout?',
        header: 'Confirmation',
        icon: 'pi pi-exclamation-triangle',
        rejectProps: {
            label: 'Cancel',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Complete'
        },
        accept: () => {
            axios.get(route('workouts.complete', workout.value.id))
        },
        reject: () => {
        }
    });
};

const delete_workout = () => {
    confirm.require({
        message: 'Are you sure you want to delete this workout?',
        header: 'Confirmation',
        icon: 'pi pi-exclamation-triangle',
        rejectProps: {
            label: 'Cancel',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Delete'
        },
        accept: () => {
            router.delete(route('workouts.destroy', workout.value.id))
        },
        reject: () => {
        }
    })
}

</script>

<template>
    <Head title="Dashboard" />
    <ConfirmDialog />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl py-4">
            <div class="w-full flex space-x-4 justify-end ">

                <RippleButton v-if="!completing" @click="delete_workout" class="bg-red-500 text-white"> <Trash2 class="inline" /> Delete Workout</RippleButton>
                <RippleButton v-if="!completing" @click="completing=true;" class="bg-green-600 text-white"> <Dumbbell class="inline" /> Start Working</RippleButton>
                <RippleButton v-if="completing" @click="complete_workout_confirmation" class="bg-green-600 text-white"> <Check class="inline" /> Complete Workout</RippleButton>
                <RippleButton v-if="completing" @click="completing=false;" class="bg-red-500 text-white"> <Play class="inline" /> Continue Recording</RippleButton>
            </div>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4" v-if="workout.exercises?.length && !completing">
                <WorkoutCard :key="exercise.id"
                             v-for="(exercise, index) in workout.exercises"
                             :hotkey="hotkeys[index]"
                             :exercise="exercise"
                             @exercise-updated="debouncedUpdate"
                />

            </div>


            <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4" v-else-if="workout.exercises?.length && completing">
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
