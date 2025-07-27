<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import {BreadcrumbItem, ExercisePlanTemplate} from '@/types';
import {Head, Link, router, usePage} from '@inertiajs/vue3';
import {VanishingInput} from "@/components/ui/vanishing-input";
import {computed, ref} from "vue";
import {Button, Card} from "primevue";
import {useDebounceFn} from "@vueuse/core";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Plan Templates',
        href: route('templates.index') ,
    },
];

const page = usePage();

const templates = ref(page.props.templates as ExercisePlanTemplate[])

const search  = ref<string>(page.props.search);

const placeholders = computed(()=>{
    return templates.value.data.map(template => template.name)
})
const debouncedSearch = useDebounceFn(async () => {
    router.get(route('templates.index'), {
        search: search.value,
    },{
        preserveScroll: true,
        preserveState: false,
    })
}, 500)



</script>

<template>
    <Head title="Templates" />
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
                <Link class="w-fit" :href="route('templates.create')">
                    <Button size="small" label="Add Template" icon="pi pi-plus" />
                </Link>
                </div>
            </div>
            <div
                class="grid grid-cols-2 z-20 sm:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-4"
                 v-if="templates.data.length">
                <Link :key="template.id" v-for="template in templates.data"
                      :href="route('templates.show', template.id)" >

                    <Card>
                        <template #content>
                            <div class="hover:opacity-20 w-full h-[100px] flex justify-center items-center">
                                <h3 class="z-20 text-2xl font-bold text-center text-primary">{{template.name}}</h3>
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
