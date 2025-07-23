<script setup lang="ts">


import {Dialog, DialogFooter, DialogHeader, DialogTrigger, DialogContent,DialogTitle,DialogDescription} from "@/components/ui/dialog";
import {Input} from "@/components/ui/input";
import {Button} from "@/components/ui/button";
import {RippleButton} from "@/components/ui/ripple-button";
import {useForm} from "@inertiajs/vue3";
import {Label} from "@/components/ui/label";
import {ref} from "vue";

const openDialog = ref(false)

const form = useForm({
    name: '',
    image: '',
})



const submit = () => {
    form.post(route('exercises.store'),{
        onSuccess : () => {
            form.reset()
            form.clearErrors()
            openDialog.value = false
        }
    })
}

</script>

<template>
    <Dialog v-model:open="openDialog">
        <DialogTrigger as-child>
            <RippleButton class="hidden md:block" > + Add Exercise</RippleButton>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[425px]">
            <form @submit.prevent="submit">
            <DialogHeader>
                <DialogTitle>Create Exercise</DialogTitle>
                <DialogDescription>
                    Create New Exercise
                </DialogDescription>
            </DialogHeader>

            <div class="grid gap-4 py-4">
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="name" class="text-right">
                            Name
                        </Label>
                        <Input v-model="form.name" id="name"  class="col-span-3" />
                        <div class="col-start-2 col-span-3 text-red-500 " v-if="form.errors.name">{{ form.errors.name }}</div>
                    </div>


                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="picture" class="text-right">Picture</Label>
                        <Input v-model="form.image" id="image" type="file" class="col-span-3" />
                        <div v-if="form.errors.image">{{ form.errors.image }}</div>
                    </div>

                </div>

            <DialogFooter>
                <Button type="submit">
                    Save changes
                </Button>
            </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>

<style scoped>

</style>
