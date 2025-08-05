<script setup lang="ts">


import {useForm} from "@inertiajs/vue3";
import {Exercise} from "@/types";
import {onMounted, ref} from "vue";
import axios from "axios";
import {Button, Dialog, FloatLabel, InputText, Panel, Select, Textarea} from "primevue";
import {RippleButton} from "@/components/ui/ripple-button";
import {
    NumberField,
    NumberFieldContent,
    NumberFieldDecrement,
    NumberFieldIncrement, NumberFieldInput
} from "@/components/ui/number-field";
import { Label } from '@/components/ui/label'
import InputError from "@/components/InputError.vue";


const props = defineProps({
    plan: Object,
})
const form  = useForm({
    name: null,
    description: null,
    exercises: [],
})

const visible = ref(true);
const emits = defineEmits(['closed'])

const exercises = ref<Exercise[]>([])

onMounted(() => {
    form.name = props.plan.name
    form.description = props.plan.description
    axios.get(route('exercises.filter'))
        .then(response => {
            exercises.value = response.data
        })

    props.plan.exercises.forEach((exercise) => {
        form.exercises.push({
            exercise: exercise,
            exercise_id: exercise.id,
            multiplier: exercise.pivot.multiplier,
            metric: exercise.pivot.metric,
        })
    })
})

const submit_form = () => {
    form.put(route('plans.update', props.plan.id), {
        preserveScroll: true,
        onSuccess: () => {visible.value= false;}
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

    const idsBeforeIndex = form.exercises.slice(0, index).map(item => item.exercise_id)
    return exercises.value.filter(item => { return !idsBeforeIndex.includes(item.id)})
}

</script>

<template>
    <Dialog
        v-model:visible="visible"
        header="Build your plan"
        @afterHide="emits('closed')"
        modal
        class="w-full md:w-4/5 mx-4 xl:w-[60%]" >

        <form  @submit.prevent="submit_form" class="grid w-full grid-cols-2 gap-x-4 gap-y-12 rounded-xl my-12">

            <FloatLabel class="col-span-full md:col-span-1">
                <InputText fluid id="name" v-model="form.name" />
                <label for="name">Name</label>
            </FloatLabel>

            <FloatLabel class="col-span-full md:col-span-1">
                    <Textarea
                        fluid
                        rows="5"
                        v-model="form.description"
                        auto-resize
                    />
                <label for="name">Description</label>
            </FloatLabel>


            <Panel header="Exercises" class="col-span-2">
                <template #header >
                    <div class="flex justify-between w-full">
                        <h3 class="text-xl">Exercises</h3>
                        <RippleButton class="float-end"  @click.prevent="add_exercise">
                            + Add Exercise
                        </RippleButton>
                    </div>
                </template>

                <div v-for="(exercise, index ) in form.exercises"
                     class="grid w-full grid-cols-1 md:grid-cols-12 space-y-8 md:space-y-4 md:gap-x-8 pt-4">
                    <div class="sm:hidden col-span-full">
                        <Button rounded size="small" severity="danger" icon="pi pi-trash"
                                raised
                                class="float-end "
                                @click="remove_exercise(index)"
                        />
                    </div>

                    <FloatLabel class="col-span-full md:col-span-4">
                        <Select
                            fluid
                            filter
                            v-model="exercise.exercise_id"
                            :options="get_remaining_exercises(index)"
                            option-label="name"
                            option-value="id"
                        />
                        <label for="name">Exercise </label>
                    </FloatLabel>

                    <div class="col-span-full md:col-span-3 h-11" >
                        <NumberField id="number_field"
                                     v-model="exercise.multiplier"
                                     class="h-full  p-select w-full"
                                     :default-value="1"
                                     :step="0.05" :min="0">
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

                    <div class="col-span-3">
                        <FloatLabel class="w-full " >
                            <InputText
                                fluid
                                class="w-full"
                                v-model="exercise.metric"
                            />
                            <label>Metric Name</label>
                        </FloatLabel>
                    </div>


                    <div class="hidden sm:block col-span-2">
                        <Button rounded size="small" severity="danger" icon="pi pi-trash"
                                raised
                                class="float-end text-white!"
                                @click="remove_exercise(index)"
                        />
                    </div>
                    <InputError class="col-span-full" :message="form.errors[`exercises.${index}.exercise_id`]"/>
                    <InputError class="col-span-full" :message="form.errors[`exercises.${index}.metric`]"/>

                </div>
            </Panel>

            <div class="col-span-full md:col-span-2">
                <RippleButton class="max-w-32 float-end" type="submit">
                    Submit
                </RippleButton>
            </div>
        </form>

    </Dialog>

</template>

<style scoped>

</style>
