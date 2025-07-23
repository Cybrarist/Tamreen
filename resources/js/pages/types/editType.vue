<script setup lang="ts">

import type {BreadcrumbItem, ExercisePlan, ExercisePlanTemplate, Item, Type} from "@/types";


import {Head, Link, router, useForm, usePage} from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import {computed, onMounted, ref} from "vue";
import {DirectionAwareHover} from "@/components/ui/direction-aware-hover";
import {RippleButton} from "@/components/ui/ripple-button";
import CloneTemplateToItem from "@/components/forms/CloneTemplateToItem.vue";
import {DataTable, Column, Panel, FloatLabel, InputText} from "primevue";
import EditItemPlan from "@/components/forms/plans/editItemPlan.vue";
import InputError from "@/components/InputError.vue";

const page = usePage()
const type = computed(() => page.props.type as Type);
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: type.value.name,
        href: route('types.index'),
    },
];


const form  = useForm({
    name: '',
})

onMounted(()=>{
    form.name = type.value.name;
})
const submit_form = () => {
    form.put(route('types.update', {
        type: type.value.id,
    }), {
        preserveScroll: true,
    });
}

</script>

<template>
    <Head :title="`Edit ${type.name}`" />
    <AppLayout :breadcrumbs="breadcrumbs">

        <h3 class="text-3xl mt-4 ">Edit {{ type.name }}</h3>
        <form  @submit.prevent="submit_form" class="grid w-full grid-cols-3 gap-x-4 gap-y-12 rounded-xl my-12">

            <div class="col-span-1">
                <FloatLabel >
                    <InputText class="w-full" id="name" v-model="form.name" />
                    <label for="name">Name</label>

                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.name" />

            </div>

            <div class="col-start-1 col-span-1">
                <RippleButton class="max-w-32 float-start" type="submit">
                    Submit
                </RippleButton>
            </div>
        </form>


    </AppLayout>

</template>

