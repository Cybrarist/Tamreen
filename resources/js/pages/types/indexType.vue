<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import {type BreadcrumbItem, Item, Type} from '@/types';
import {Head, Link, router, usePage} from '@inertiajs/vue3';
import {Button, Card} from 'primevue';
import {VanishingInput} from "@/components/ui/vanishing-input";
import {computed, ref } from "vue";
import {useDebounceFn} from "@vueuse/core";
import Pagination from "@/components/Pagination.vue";
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Types',
        href: route('types.index'),
    },
];

const page = usePage();

const types = page.props.types as Type[]

const search  = ref<string>(page.props.search);

const placeholders = computed(()=>{
    return types.data.map(type => type.name)
})

const debouncedSearch = useDebounceFn(async () => {
    router.get(route('types.index'), {
        search: search.value,
    },{
        preserveScroll: true,
        preserveState: false,
    })
}, 300)

</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div  class="flex h-fit overflow-auto flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="w-full flex justify-between sticky">
                <div class="w-full flex justify-between">
                    <div class="w-full md:w-1/3 flex flex-row">
                        <VanishingInput
                            class="w-full"
                            v-model="search"
                            @change="debouncedSearch"
                            :placeholders="placeholders"
                        />
                    </div>

                    <Link :href="route('types.create')">
                        <Button size="small" label="Add Type" icon="pi pi-plus" />
                    </Link>
                </div>
            </div>

            <div class="grid auto-rows-min gap-4 md:grid-cols-6 grid-cols-2" v-if="types.data.length">
                <Link :key="type.id" v-for="type in types.data"
                      :href="route('types.show', type.id)">
                    <Card>
                        <template #content>
                            <div class="hover:opacity-20 w-full h-[100px] flex justify-center items-center">
                                <h3 class="z-20 text-xl font-bold text-center text-black dark:text-white">{{type.name}}</h3>
                            </div>
                        </template>
                    </Card>


                </Link>
                <Pagination class="col-span-full" :next-link="types.next_page_url" :prev-link="types.prev_page_url" />

            </div>
            <div v-else>
                No Types Found
            </div>
        </div>
    </AppLayout>
</template>
