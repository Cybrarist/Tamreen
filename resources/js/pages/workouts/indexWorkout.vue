<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import {type BreadcrumbItem, Workout} from '@/types';
import {Head, Link, usePage} from '@inertiajs/vue3';
import { ref } from "vue";
import Pagination from "@/components/Pagination.vue";
import PendingItemCard from "@/components/PendingItemCard.vue";
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Pending Workouts',
        href: route('workouts.index'),
    },
];

const page = usePage();
const workouts = ref<Workout[]>(page.props.workouts as Workout[])


</script>

<template>
    <Head title="Workouts" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div  class="flex h-fit overflow-auto flex-1 flex-col gap-4 rounded-xl p-4">

            <div v-if="workouts.data.length" class="grid grid-cols-2 z-20 sm:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-4" >
                <Link :key="workout.id" v-for="workout in workouts.data"
                      :href="route('workouts.show', workout.id)"
                      class="relative"
                >
                    <PendingItemCard :exercises="workout.exercises"  :item="workout.item"/>
                </Link>

                <Pagination class="col-span-full" :next-link="workouts.next_page_url" :prev-link="workouts.prev_page_url" />
            </div>
            <div v-else>
                    No workouts Found
            </div>
        </div>
    </AppLayout>
</template>
