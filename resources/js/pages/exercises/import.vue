<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, } from '@/types';
import {Head, useForm} from '@inertiajs/vue3';
import {ToggleSwitch, FileUpload} from "primevue";
import {RippleButton} from "@/components/ui/ripple-button";
import InputError from "@/components/InputError.vue";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Exercises',
        href: route('exercises.create'),
    },
];

const form  = useForm({
    all_users:false,
    file : null,
})


const submit_form = () => {
    form.post(route('exercises.start-import'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
        }
    });
}
</script>

<template>
    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-fit overflow-auto flex-1 flex-col gap-4 rounded-xl p-4">
            <h3 class="text-3xl mt-4 ">Create Exercise</h3>
            <form  @submit.prevent="submit_form" class="grid w-full grid-cols-3 gap-x-4 gap-y-12 rounded-xl my-12">

                <div class="col-span-full flex-col flex space-y-4">
                    <label for=""> Do you want exercises to be available for all users?</label>
                    <ToggleSwitch v-model="form.all_users" />
                    <InputError :message="form.errors.all_users" v-if="form.errors.all_users" />

                </div>

                <div class="start-col-1 col-span-full md:col-span-2 space-y-4">
                    <h2 class="text-xl"> Json File </h2>
                    <FileUpload
                        :show-upload-button="false "
                        :show-cancel-button="false"
                        v-model="form.file"
                        @input="form.file = $event.target.files[0]"
                        mode="basic"
                        accept=".json">
                    </FileUpload>
                    <InputError :message="form.errors.file" v-if="form.errors.file"/>
                </div>



                <RippleButton class="md:col-start-1 w-56"  type="submit"> Import </RippleButton>

        </form>
        </div>

    </AppLayout>
</template>
