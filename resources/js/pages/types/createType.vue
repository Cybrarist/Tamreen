<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem} from '@/types';
import {Head, useForm, usePage} from '@inertiajs/vue3';
import {FloatLabel, InputText, Textarea, FileUpload, Select} from "primevue";
import {RippleButton} from "@/components/ui/ripple-button";
import InputError from "@/components/InputError.vue";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Types',
        href: route('types.create'),
    },
];

const form  = useForm({
    name: '',
})

const submit_form = () => {
    form.post(route('types.store'), {
        preserveScroll: true,
    });
}

</script>

<template>
    <Head title="Create Type" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-fit overflow-auto flex-1 flex-col gap-4 rounded-xl p-4">
            <h3 class="text-3xl ">Create Type</h3>
            <form  @submit.prevent="submit_form" class="grid w-full grid-cols-3 gap-x-4 gap-y-12 rounded-xl my-12">

                <div class="col-span-full sm:col-span-2 md:col-span-1">
                    <FloatLabel>
                        <InputText fluid class="w-full" id="name" v-model="form.name" />
                        <label for="name">Name</label>

                    </FloatLabel>
                    <InputError class="mt-2" :message="form.errors.name" />

                </div>

                <RippleButton class="sm:col-start-1 w-32"  type="submit"> Submit </RippleButton>
            </form>

        </div>



    </AppLayout>
</template>
