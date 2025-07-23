<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

import { Toaster } from '@/components/ui/sonner'
import 'vue-sonner/style.css'
import {usePage} from "@inertiajs/vue3";
import {computed, onMounted, onUpdated, watch} from "vue";
import {toast} from "vue-sonner";
const page = usePage();


onMounted(() => {
    if (page.props.flash.severity === 'success')
        toast.success(page.props.flash.message)
})

watch(() => page.props.flash, flash => {
    if (flash.severity === 'success')
        toast.success(flash.message)
}, {deep: true})


</script>

<template>
    <Toaster  rich-colors position="top-right" theme="system"/>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-8">
            <slot />

        </div>
    </AppLayout>
</template>
