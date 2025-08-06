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
import {Dialog, Carousel, Image} from "primevue";

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

}, 300)

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


const visible= ref(false)
const exercise_details = ref(null)

const show_exercise_details = (exercise) => {
    visible.value = true
    exercise_details.value = exercise
}
</script>

<template>
    <Head title="Dashboard" />
    <ConfirmDialog />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl py-4">
            <div class="w-full flex space-x-4 justify-between px-2 md:justify-end ">
                <RippleButton v-if="!completing" @click="delete_workout" class="bg-red-500 text-white"> <Trash2 class="inline" /> Delete Workout</RippleButton>
                <RippleButton v-if="!completing" @click="completing=true;" class="bg-green-600 text-white"> <Dumbbell class="inline" /> Start Working</RippleButton>
                <RippleButton v-if="completing" @click="complete_workout_confirmation" class="bg-green-600 text-white"> <Check class="inline" /> Complete Workout</RippleButton>
                <RippleButton v-if="completing" @click="completing=false;" class="bg-red-500 text-white"> <Play class="inline" /> Continue Recording</RippleButton>
            </div>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4 px-4" v-if="workout.exercises?.length && !completing">
                <WorkoutCard :key="exercise.id"
                             v-for="(exercise, index) in workout.exercises"
                             :hotkey="hotkeys[index]"
                             :exercise="exercise"
                             @exercise-updated="debouncedUpdate"
                             @show-exercise="show_exercise_details"
                />

            </div>


            <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4 px-4" v-else-if="workout.exercises?.length && completing">
                <CompleteWorkoutCard
                            :key="exercise.id"
                             v-for="(exercise, index) in workout.exercises"
                             :hotkey="hotkeys[index]"
                             :exercise="exercise"
                             @exercise-updated="debouncedUpdate"
                             @show-exercise="show_exercise_details"

                />
            </div>

            <div v-else>
                No Items Found
            </div>
        </div>


        <Dialog v-model:visible="visible"
                header="Exercise Details"
                modal
                class="space-y-4"
                @after-hide="visible=false">

            <div v-if="exercise_details.images?.length > 0  || exercise_details.videos?.length > 0 " class="grid grid-cols-3 gap-4">
                <Image v-for="image in exercise_details.images" :src="'/storage/exercises/' + image" class="m-auto" preview
                       :pt="{
                                    root:{
                                        class:'w-full'
                                    },
                                    image:{
                                        class: 'rounded-lg  mx-auto max-h-32 '
                                    }
                                    }"
                />

                <video v-for="video in exercise_details.videos"
                       :src="'/storage/exercises/' + video"
                       muted controls
                       class="max-h-36"
                />
            </div>

            <div v-else>
                No images or videos found for this exercise
            </div>

        </Dialog>

    </AppLayout>
</template>
