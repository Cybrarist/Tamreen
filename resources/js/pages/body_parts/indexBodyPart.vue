<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import {type BreadcrumbItem, Exercise} from '@/types';
import {Head, Link, usePage} from '@inertiajs/vue3';
import {GlareCard} from "@/components/ui/glare-card";
import {RippleButton} from "@/components/ui/ripple-button";
import {VanishingInput} from "@/components/ui/vanishing-input";
import {computed, ref} from "vue";
import {HoverCard, HoverCardTrigger, HoverCardContent} from "@/components/ui/hover-card";
import {ExerciseCard} from "@/components/ui/exercise-card";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Exercises',
        href: '/exercises',
    },
];

const page = usePage();

const bodyParts = page.props.bodyParts as BodyPart[]
const exercises = page.props.exercises as Exercise[]

const search  = ref<string>('');

const placeholders = computed(()=>{
    return bodyParts.map(item => item.name)
})


</script>

<template>
    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="w-full flex justify-between">
                <div class="w-full md:w-1/3">
                    <VanishingInput
                        class="w-full"
                        v-model="search"
                        :placeholders="placeholders"
                    />
                </div>

                <RippleButton class="hidden md:block"> + Add Exercise</RippleButton>
            </div>
            <div class="grid auto-rows-min gap-4 md:grid-cols-4 grid-cols-2" v-if="bodyParts.length">
                <Link :key="item.id" v-for="item in bodyParts"
                      :href="route('items.show', item.id)" >
                    <ExerciseCard>
                        <div class="w-full h-full flex justify-center items-center">
                            <h3 class="z-20 text-2xl text-white font-bold">{{item.name}}</h3>
                            <img :src="'/storage/body_parts/abs.jpg'"
                                 class="object-cover h-full w-full absolute z-10 opacity-50"
                            />
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
