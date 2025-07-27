<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Exercise} from '@/types';
import {Head, useForm, usePage} from '@inertiajs/vue3';
import {FloatLabel, InputText, Select, Textarea, Panel, Button} from "primevue";
import {RippleButton} from "@/components/ui/ripple-button";
import InputError from "@/components/InputError.vue";
import {NumberField ,NumberFieldContent, NumberFieldInput, NumberFieldIncrement, NumberFieldDecrement} from "@/components/ui/number-field";
import {Label} from "@/components/ui/label";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Plan Template',
        href: route('templates.index'),
    },
];

const page = usePage();

const exercises = page.props.exercises as Exercise[]

const form  = useForm({
    name: '',
    description: '',
    exercises: [],
})

const submit_form = () => {
    form.post(route('templates.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
        }
    });
}

const add_exercise = () => {
    form.exercises.push({
        multiplier: 1,
    });
}

const remove_exercise = (index) => {
    form.exercises.splice(index, 1)
}


const get_remaining_exercises = (index) => {
    const ids_before_index = form.exercises.slice(0, index).map(item => item.exercise_id)
    return exercises.filter(item => { return !ids_before_index.includes(item.id)})
}

</script>

<template>
    <Head title="Create Template" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <h3 class="text-3xl mt-4 ">Create Plan Template</h3>
            <form  @submit.prevent="submit_form" class="grid w-full grid-cols-3 gap-x-4 gap-y-6 rounded-xl my-12">

                <div class="col-span-full sm:col-span-1 flex flex-col space-y-2">
                    <FloatLabel >
                        <InputText fluid v-model="form.name" :invalid="form.errors.name" class="w-full" id="name"  />
                        <label for="name">Name</label>
                    </FloatLabel>
                    <InputError :message="form.errors.name" />

                </div>


                <div class="col-span-full sm:col-start-1 sm:col-span-2 flex  flex-col space-y-2">
                    <FloatLabel >
                        <Textarea
                            fluid
                            class="w-full"
                            rows="5"
                            v-model="form.description"
                            auto-resize
                            id="description"
                            :invalid="form.errors.description"
                        />
                        <label for="description">Description</label>
                    </FloatLabel>
                    <InputError :message="form.errors.description" />
                </div>

                <Panel header="Exercises" class="col-span-full  sm:col-span-2">
                    <template #header >
                        <div class="flex justify-between w-full">
                            <h3 class="text-xl">Exercises</h3>
                            <RippleButton @click.prevent="false" class="float-end"  @click="add_exercise">
                                + Add Exercise
                            </RippleButton>
                        </div>
                    </template>

                    <div v-if="form.exercises.length" v-for="(exercise, index ) in form.exercises"
                         class="grid w-full grid-cols-6 space-y-8 md:space-y-4 gap-x-8 pt-4">
                        <div class="sm:hidden col-span-full">
                            <Button rounded size="small" severity="danger" icon="pi pi-trash"
                                    raised
                                    class="float-end "
                                    @click="remove_exercise(index)"
                            />
                        </div>

                        <FloatLabel class="col-span-full md:col-span-2">
                            <Select
                                class="w-full"
                                filter
                                v-model="exercise.exercise_id"
                                :options="get_remaining_exercises(index)"
                                option-label="name"
                                option-value="id"
                            />
                            <label for="name">Exercise </label>
                        </FloatLabel>

                        <div class="col-span-full md:col-span-2 h-11" >
                            <NumberField id="number_field"
                                         v-model="exercise.multiplier"
                                         class="h-full  p-select w-full"
                                         :default-value="1"
                                         :step="0.1" :min="0">
                                <Label for="number_field" class="absolute top-[var(--p-floatlabel-over-active-top)]
                             text-[var(--p-floatlabel-active-color)] font-normal left-[var(--p-floatlabel-position-x)]"
                                       style="font-size:var(--p-floatlabel-active-font-size)"
                                >Multiplier</Label>
                                <NumberFieldContent class="w-full ">
                                    <NumberFieldDecrement />
                                    <NumberFieldInput class="h-full shadow-none border-0 " />
                                    <NumberFieldIncrement  class="cursor-pointer hover:opacity-25"/>
                                </NumberFieldContent>
                            </NumberField>
                        </div>

                        <div class="hidden sm:block col-span-2">
                            <Button rounded size="small" severity="danger" icon="pi pi-trash"
                                    raised
                                    class="float-end "
                                    @click="remove_exercise(index)"
                            />
                        </div>

                        <InputError class="col-span-full" :message="form.errors[`exercises.${index}.exercise_id`]"/>

                    </div>
                    <span v-else> No Exercises Added </span>
                </Panel>


                <div class="col-span-full md:col-span-2">
                    <RippleButton class="max-w-32 float-end" type="submit">
                        Submit
                    </RippleButton>
                </div>

        </form>


    </AppLayout>
</template>
