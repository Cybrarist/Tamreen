<script setup lang="ts">

import {onMounted, ref} from "vue";
import {FloatLabel, InputText, Select, Dialog, Password} from "primevue";
import {useForm} from "@inertiajs/vue3";
import {RippleButton} from "@/components/ui/ripple-button";
import InputError from "@/components/InputError.vue";


const visible = ref(true)

const emits = defineEmits([
    'closed'
])


const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'user',
})


const submit_form = () => {
    form.post(route('users.store'), {
        onFinish: () => {
            form.reset();
            visible.value = false;
        },
    });
}
</script>

<template>

    <Dialog v-model:visible="visible"
            @after-hide="emits('closed')"
            modal
            header="Add User"
            class="w-96"
    >

        <form @submit.prevent="submit_form" class="flex flex-col space-y-8">
            <FloatLabel class="col-span-full md:col-span-1 mt-8">
                <InputText required fluid id="name" v-model="form.name" />
                <label for="name">Name *</label>
            </FloatLabel>
            <InputError :message="form.errors.name" />


            <FloatLabel class="col-span-full md:col-span-1 ">
                <InputText required fluid id="name" v-model="form.email" />
                <label for="name">Email *</label>
            </FloatLabel>
            <InputError :message="form.errors.email" />


            <FloatLabel class="col-span-full md:col-span-1">
                <Password v-model="form.password" required toggleMask fluid />
                <label for="password">Password *</label>
            </FloatLabel>
            <InputError :message="form.errors.password" />


            <FloatLabel class="col-span-full md:col-span-1">
                <Password v-model="form.password_confirmation" required toggleMask fluid />
                <label for="password_confirmation">Password Confirmation *</label>
            </FloatLabel>
            <InputError :message="form.errors.password_confirmation" />

            <FloatLabel class="col-span-full md:col-span-4">
                <Select
                    fluid
                    filter
                    v-model="form.role"
                    :options="['user', 'admin']"
                />
                <label for="name">Role </label>
            </FloatLabel>
            <InputError :message="form.errors.role" />


            <div class="w-full">
                <RippleButton class="w-32 float-end" type="submit">
                    Submit
                </RippleButton>
            </div>

        </form>


    </Dialog>
</template>

<style scoped>

</style>
