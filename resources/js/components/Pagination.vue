<script setup lang="ts">

import {Link} from "@inertiajs/vue3";

defineProps({
    nextLink: String,
    prevLink: String,
})
</script>

<template>
    <div class="flex items-center justify-between flex-wrap -mb-1" v-if="prevLink || nextLink">
        <Link  class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
               :class="{
            'opacity-50 cursor-not-allowed': !prevLink
               }"
               :href="prevLink ?? '#'"
                >
            Previous
        </Link>
        <Link
              class="float-end mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
              :class="{
            'opacity-50 cursor-not-allowed': !nextLink
               }"
                :href="nextLink ?? '#'" >
            Next
        </Link>
    </div>
</template>

<style scoped>

</style>
