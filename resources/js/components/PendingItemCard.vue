<script setup lang="ts">

import {Tag} from "primevue";
import {HoverCard, HoverCardTrigger} from "@/components/ui/hover-card";
import {GlareCard} from "@/components/ui/glare-card";
import {Exercise} from "@/types";
import {Knob} from 'primevue';


const props = defineProps({
    item: {
        type: Object as () => Exercise,
        required: true,
    },
    exercises: {
        type: Array as () => Exercise[],
    }
})

const progress = (props.exercises?.reduce((acc, exercise) => acc + exercise.pivot.completed, 0) /  props.exercises?.reduce((acc, exercise) => acc + exercise.pivot.total, 0) * 100).toFixed(0)
</script>

<template>
    <Tag :value="item.type?.name" class="absolute -left-2 top-4 z-10" />
    <HoverCard  class="bg-white" :open-delay="0" :close-delay="0">
        <HoverCardTrigger>
            <GlareCard
                class="flex flex-col items-center justify-center ">
                <Knob class="absolute bg-primary-foreground rounded-full" :min="0" :max="100"
                      valueColor="Green" readonly
                      :value-template="(val) => val +'%'"
                      prefix="%"
                      v-model="progress" :strokeWidth="5" >
                </Knob>

                <img :title="item.name" :alt="item.name" :src="'/storage/items/' + item.image"
                     class="object-cover h-full w-full "
                />
            </GlareCard>
        </HoverCardTrigger>
    </HoverCard>
    <Tag :value="item.name" severity="secondary"
         class="absolute  bottom-6 rounded-none! text-center right-0 left-0 mx-auto z-10 "
    />
</template>

<style scoped>

</style>
