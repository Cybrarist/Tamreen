<script setup lang="ts">

import {NumberFieldInput,NumberFieldIncrement , NumberFieldDecrement ,NumberField, NumberFieldContent} from "@/components/ui/number-field";
import { useMagicKeys, whenever } from '@vueuse/core'
import {Tag} from "primevue";

const { current } = useMagicKeys()

const props = defineProps({
    exercise: Object,
    hotkey: String,

})

const emits = defineEmits(['exercise-updated', 'show-exercise'])

whenever(
    () => props.hotkey && current.has(props.hotkey) && !current.has('shift'),
    () => {emits('exercise-updated'); props.exercise.pivot.count++},
)

whenever(
    () => props.hotkey &&  current.has(props.hotkey) && current.has('shift'),
    () => { emits('exercise-updated'); props.exercise.pivot.count--;},
)


</script>

<template>

        <div class="flex flex-col items-center justify-center w-full">
            <div class="w-full flex items-center justify-center h-42 md:h-64 bg-gray-300 bg-center bg-cover rounded-lg shadow-md hover:cursor-pointer"
                 :style="`background-image: url(/storage/exercises/${((exercise.images?.length) ? exercise.images[0] : 'exercise.png')})`"
                 @click="emits('show-exercise',exercise )"

            >
                <Tag :value="`${exercise.pivot.metric} (${props.hotkey})`" severity="secondary"
                     class="mx-auto w-full text-center"
                     :pt:label:class="'text-lg md:text-3xl font-bold text-primary capitalize'"
                     :pt:root:class="'rounded-none!'"
                />
            </div>


            <div class="flex items-center justify-between px-3 py-2
            flex-col md:flex-row
             w-42 lg:w-50 xl:w-64 -mt-10 overflow-hidden  rounded-lg shadow-lg bg-primary-foreground">
                    <NumberField :model-value="exercise.pivot.count"
                                 @update:model-value=" (value) => {
                                     exercise.pivot.count=value
                             }"
                                 class="md:max-w-3/5 text-center"
                                 :default-value="exercise.pivot.count"
                    >
                        <NumberFieldContent>
                            <NumberFieldDecrement />
                            <NumberFieldInput  />
                            <NumberFieldIncrement />
                        </NumberFieldContent>
                    </NumberField>
                    <span>x {{exercise.pivot.multiplier}} = </span>
                    <span class="font-bold text-gray-800 dark:text-gray-200">{{Math.round(exercise.pivot.count * exercise.pivot.multiplier)}}</span>
            </div>
        </div>

</template>

<style scoped>

</style>
