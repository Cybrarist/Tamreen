<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import {type BreadcrumbItem, Item} from '@/types';
import {Head, Link, router, usePage} from '@inertiajs/vue3';
import { Button } from 'primevue';
import {VanishingInput} from "@/components/ui/vanishing-input";
import {computed, ref } from "vue";
import {useDebounceFn} from "@vueuse/core";
import Pagination from "@/components/Pagination.vue";
import ItemCard from "@/components/ItemCard.vue";
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
    },
];

const page = usePage();
const items = ref<Item[]>(page.props.items as Item[])

const search  = ref<string>(page.props.search);

const placeholders = computed(()=>{
    return items.value.data.map(item => item.name)
})

const debouncedSearch = useDebounceFn(async () => {
    router.get(route('items.index'), {
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
        <div class="flex h-fit overflow-auto flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="w-full flex justify-between">
                <div class="w-full flex justify-between items-center">
                    <VanishingInput
                        class="w-3/5 sm:w-2/3 lg:w-1/3"
                        v-model="search"
                        @change="debouncedSearch"
                        :placeholders="placeholders"
                    />

                    <Link class="w-fit" :href="route('items.create')">
                        <Button size="small" label="Add Item" icon="pi pi-plus" />
                    </Link>
                </div>
            </div>

            <div v-if="items.data.length"
                 class="grid grid-cols-2 z-20 sm:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-4 " >
                <Link :key="item.id" v-for="item in items.data"
                      :href="route('items.show', item.id)"
                      class="relative z-20">
                    <ItemCard :item="item" />
                </Link>

                <Pagination class="col-span-full" :next-link="items.next_page_url" :prev-link="items.prev_page_url" />
            </div>
            <div v-else>
                    No Items Found
            </div>
        </div>
    </AppLayout>
</template>
