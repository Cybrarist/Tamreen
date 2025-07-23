<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import {BreadcrumbItem, ExercisePlanTemplate} from '@/types';
import {Head, Link, usePage} from '@inertiajs/vue3';
import {GlareCard} from "@/components/ui/glare-card";
import {RippleButton} from "@/components/ui/ripple-button";
import {VanishingInput} from "@/components/ui/vanishing-input";
import {computed, ref} from "vue";
import {Button, Card} from "primevue";
import {ExerciseCard} from "@/components/ui/exercise-card";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Plan Templates',
        href: route('templates.index') ,
    },
];

const page = usePage();

const templates = page.props.templates as ExercisePlanTemplate[]

const search  = ref<string>('');

const placeholders = computed(()=>{
    return templates.map(item => item.name)
})



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
                <Link :href="route('templates.create')">
                    <Button size="small" label="Add Template" icon="pi pi-plus" />
                </Link>

            </div>
            <div class="grid auto-rows-min gap-4 md:grid-cols-6 grid-cols-2" v-if="templates.length">
                <Link :key="template.id" v-for="template in templates"
                      :href="route('templates.show', template.id)" >

                    <Card>
                        <template #content>
                            <div class="hover:opacity-20 w-full h-[100px] flex justify-center items-center">
                                <h3 class="z-20 text-2xl font-bold text-black dark:text-white">{{template.name}}</h3>
                            </div>
                        </template>
                    </Card>


                </Link>
            </div>
            <div v-else>
                No Plan Templates Found
            </div>
        </div>


    </AppLayout>
</template>
