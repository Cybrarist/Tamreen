<script setup lang="ts">

import {NumberFieldInput,NumberFieldIncrement , NumberFieldDecrement ,NumberField, NumberFieldContent} from "@/components/ui/number-field";
import { useMagicKeys, whenever } from '@vueuse/core'
import {CardSpotlight} from "@/components/ui/card-spotlight";
import RecordExerciseCard from "@/components/ui/record-exercise-card/RecordExerciseCard.vue";

const { current } = useMagicKeys()

const props = defineProps({
    exercise: Object,
    hotkey: String,

})

const emits = defineEmits(['exercise-updated'])

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
    <RecordExerciseCard>
        <div class="w-full h-full flex justify-center items-center">
            <h3 class="z-20 text-2xl font-bold text-primary-foreground text-center px-2">{{exercise.name}}</h3>

            <img :src="'/storage/exercises/' + ((exercise.images?.length) ? exercise.images[0] : 'abs.jpg')"
                 class="object-cover h-full w-full absolute z-10 opacity-50"
                 :alt="exercise.name"/>
        </div>
    </RecordExerciseCard>
</template>

<style scoped>

</style>
