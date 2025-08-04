<script setup lang="ts">

import type {BreadcrumbItem, ExercisePlan, ExercisePlanTemplate, Item} from "@/types";


import {Head, Link, router, usePage} from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import {computed, ref} from "vue";
import {DirectionAwareHover} from "@/components/ui/direction-aware-hover";
import {RippleButton} from "@/components/ui/ripple-button";
import CloneTemplateToItem from "@/components/forms/CloneTemplateToItem.vue";
import {DataTable, Column, Panel, Button} from "primevue";
import EditItemPlan from "@/components/forms/plans/editItemPlan.vue";
import ConfirmDialog from 'primevue/confirmdialog';
import { useConfirm } from "primevue/useconfirm";
import { SquarePen , Plus, Trash2} from "lucide-vue-next";
import {DropdownMenu, DropdownMenuTrigger, DropdownMenuContent, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuItem} from "@/components/ui/dropdown-menu";
import {ScrollPanel} from 'primevue'

const page = usePage()
const item = computed(() => page.props.item as Item);
const plan_dialog = ref(false)
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: item.value.name,
        href: route('dashboard'),
    },
];

const selected_plan = ref<ExercisePlan | null>(null)


const create_new_workout = (plan_id: number) => {
    router.post(route('workouts.store'), {
        item_id: item.value.id,
        exercise_plan_id: plan_id
    })
}



const confirm = useConfirm();
const delete_confirmation = (id:number) => {
    confirm.require({
        message: 'Deleting this item will remove everything related to it (plan, workout, etc). Are you sure you want to delete this item?',
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
            router.delete(route('items.destroy', {
                item: id
            }))
        },
        reject: () => {
        }
    });
};
const delete_plan_confirmation = (id:number) => {
    confirm.require({
        message: 'Do you want to remove the current plan ?',
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
            router.delete(route('plans.destroy', {
                plan: id
            }))
        },
        reject: () => {
        }
    });
};


</script>

<template>
    <Head title="Dashboard" />
    <ConfirmDialog />

    <AppLayout :breadcrumbs="breadcrumbs">
        <CloneTemplateToItem @cloned="router.reload()" v-if="plan_dialog" @closed="plan_dialog=false" :item_id="item.id" />

        <div class="flex h-fit overflow-auto flex-1 flex-col gap-4 rounded-xl p-4">

        <section class="w-full mt-8 flex items-end justify-between sm:justify-end space-x-8">
            <Link :href="route('workouts.index', {item_id: item.id})">
                <Button severity="warn" label="Pending Workouts" class="text-white!"/>
            </Link>
            <DropdownMenu >
                <DropdownMenuTrigger class="hover:cursor-pointer">
                    <RippleButton >Actions</RippleButton>
                </DropdownMenuTrigger>
                <DropdownMenuContent>
                    <DropdownMenuItem  @click="plan_dialog=true" class="hover:cursor-pointer">
                        <Plus /> Add New Plan
                    </DropdownMenuItem>
                    <DropdownMenuItem @click="router.get(route('items.edit', { item: item.id}))" class="hover:cursor-pointer">
                         <SquarePen /> Edit
                    </DropdownMenuItem>
                    <DropdownMenuItem
                        @click="delete_confirmation(item.id)"
                        class="hover:cursor-pointer hover:text-red-600!">
                        <Trash2 />
                        Delete</DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
        </section>

        <div class="flex flex-col  md:flex-row flex-wrap p-8">
            <div class="w-full md:w-2/5 flex items-center justify-center">
                <DirectionAwareHover
                   :image-url="`/storage/items/${item.image}`"
                    class="shadow-xl max-w-3/5"
                   image-class="w-full h-full object-cover hover:scale-110"
                />
            </div>

            <div class="w-full mt-8 md:mt-0 md:w-3/5 flex-col space-y-12">
                <h1 class="text-center text-3xl"> {{item.name }}</h1>
                <ScrollPanel header="Description">
                    <p class="m-0 px-8">
                        {{item.description}}
                    </p>
                </ScrollPanel>

                <section class="grid grid-cols-3">

                </section>

            </div>


        </div>


        <section v-if="item.exercise_plans.length" id="plans" class="mb-12 w-full flex flex-col gap-y-12 overflow-auto max-h-[50rem]">
            <h3 class="text-2xl font-bold">
                Plans
            </h3>
            <div v-for="plan in item.exercise_plans" class="w-full">
                <Panel toggleable>
                    <template #header >
                        <div class="flex justify-between items-center w-full">
                            <h3 class="text-xl ">{{plan.name}}</h3>

                            <div >
                                <DropdownMenu >
                                    <DropdownMenuTrigger class="hover:cursor-pointer">
                                        <RippleButton >Actions</RippleButton>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent>
                                        <DropdownMenuItem
                                            @click="create_new_workout(plan.id)"
                                            class="hover:cursor-pointer hover:text-green-700!"
                                        >New Session</DropdownMenuItem>
                                        <DropdownMenuItem @click="selected_plan=plan" class="hover:cursor-pointer">Edit</DropdownMenuItem>
                                        <DropdownMenuItem
                                            @click="delete_plan_confirmation(plan.id)"
                                            class="hover:cursor-pointer hover:text-red-600!">Delete</DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </div>
                        </div>
                    </template>

                    <DataTable :value="plan.exercises"
                               auto-layout
                               class="w-full"
                               :pt="{
                            column: {
                              headerCell: {
                                class: ['!bg-transparent'],
                              },
                            },
                        }"
                    >
                        <Column field="name" header="Exercise"></Column>
                        <Column field="pivot.multiplier" header="Multiplier"></Column>
                        <Column field="pivot.metric" header="Metric"></Column>
                    </DataTable>

                </Panel>


            </div>
        </section>

        </div>

        <edit-item-plan v-if="selected_plan" :plan="selected_plan" @closed="selected_plan=null; " />

    </AppLayout>

</template>

