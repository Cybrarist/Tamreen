<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import {type BreadcrumbItem, User} from '@/types';
import {Head, router, usePage} from '@inertiajs/vue3';
import { Button, DataTable, Column, Tag, ConfirmDialog } from 'primevue';
import {VanishingInput} from "@/components/ui/vanishing-input";
import {computed, ref } from "vue";
import {useDebounceFn} from "@vueuse/core";
import Pagination from "@/components/Pagination.vue";
import EditUser from "@/components/EditUser.vue";
import CreateUser from "@/components/CreateUser.vue";
import {useConfirm} from "primevue/useconfirm";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'User',
        href: route('users.index'),
    },
];

const page = usePage();
const users = computed(()=>page.props.users as User[])

const search  = ref<string>(page.props.search);

const placeholders = computed(()=>{
    return users.value.data.map(item => item.name)
})

const debouncedSearch = useDebounceFn(async () => {
    router.get(route('users.index'), {
        search: search.value,
    },{
        preserveScroll: true,
        preserveState: false,
    })
}, 500)


const create_user = ref(false)
const user_selected = ref({})


const confirm = useConfirm();
const delete_user = (id: number) => {
   confirm.require({
        message: 'Are you sure you want to delete this user and all of their data?',
        header: 'Confirm',
        icon: 'pi pi-exclamation-triangle',
        acceptClass: 'p-button-danger',
     rejectProps: {
       label: 'Cancel',
       severity: 'secondary',
       outlined: true
     },
     acceptProps: {
       label: 'Delete'
     },
     accept: () => {
       router.delete(route('users.destroy', id), {
         preserveScroll: true,
       })
     },
     reject: () => {}

  })
}
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex h-fit overflow-auto flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="w-full flex justify-between">
                <div class="w-full flex justify-between users-center">
                    <VanishingInput
                        class="w-3/5 sm:w-2/3 lg:w-1/3"
                        v-model="search"
                        @change="debouncedSearch"
                        :placeholders="placeholders"
                    />

                    <Button @click="create_user=true" size="small" label="Add User" icon="pi pi-plus" />
                </div>
            </div>


            <div class="w-full">
                <DataTable :value="users.data" stripedRows>
                    <Column field="name" header="Name"></Column>
                    <Column field="email" header="Email"></Column>
                    <Column field="role" header="Role">
                        <template #body="slotProps">
                            <Tag severity="primary" class="capitalize" :value="slotProps.data.role" />
                        </template>
                    </Column>
                    <Column>
                      <template #body="slotProps">
                        <div class="space-x-4 space-y-4 sm:space-y-0">
                            <Button severity="warning" icon="pi pi-pencil" rounded @click="user_selected=slotProps.data" />
                            <Button class="text-white!" severity="danger" icon="pi pi-trash" rounded @click="delete_user(slotProps.data.id)" />
                        </div>
                      </template>
                    </Column>
                </DataTable>

                <Pagination class="mt-8" :next-link="users.next_page_url" :prev-link="users.prev_page_url" />
            </div>

        </div>

        <create-user v-if="create_user" @closed="create_user=false" />
        <EditUser v-if="user_selected.id" @closed="user_selected={}" :user="user_selected"/>

      <ConfirmDialog />

    </AppLayout>
</template>
