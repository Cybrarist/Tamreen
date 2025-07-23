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
    if (!search.value) {
        router.get(route('items.index'))
        items.value = page.props.items as Item[]
        return
    }

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

                    <Link :href="route('items.create')">
                        <Button size="small" label="Add Item" icon="pi pi-plus" />
                    </Link>
                </div>
            </div>

            <div v-if="items.data.length" class="grid w-full auto-rows-min gap-4 md:grid-cols-6 grid-cols-2" >
                <Link :key="item.id" v-for="item in items.data"
                      :href="route('items.show', item.id)"
                      class="relative"
                >
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
