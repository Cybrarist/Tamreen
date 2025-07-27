<script setup lang="ts">

import {Tag} from "primevue";
import {HoverCard, HoverCardTrigger} from "@/components/ui/hover-card";
import {GlareCard} from "@/components/ui/glare-card";
import {Exercise} from "@/types";


defineProps({
    item: {
        type: Object as () => Exercise,
        required: true,
    },

})
</script>

<template>
    <Tag :value="item.type?.name" class="absolute  sm:-ms-2 top-4 z-10" />
    <HoverCard  class="bg-white" :open-delay="0" :close-delay="0">
        <HoverCardTrigger>
            <GlareCard
                class="flex flex-col items-center justify-center ">
                <img v-if="item.image" :title="item.name"  :src="'/storage/items/' + item.image"
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
