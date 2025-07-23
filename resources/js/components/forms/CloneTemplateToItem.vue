<script setup lang="ts">

import {onMounted, ref} from "vue";
import {RippleButton} from "@/components/ui/ripple-button";
import {Dialog,Select,FloatLabel} from 'primevue'
import axios from "axios";

const props = defineProps({
    item_id : Number,
})

const selected_template = ref(null)

const templates = ref([])

onMounted(() => {
  axios.get(route('templates.filter'))
      .then(response => {
        templates.value = response.data
    })
})

const visible = ref(true);
const emits = defineEmits(['closed','cloned'])


const clone_template = () => {
  axios.get(route('templates.clone',{
    template: selected_template.value,
    item: props.item_id,
  })).then(response => {
      emits('cloned')
      visible.value = false
      emits('closed')
  })
}

</script>

<template>

    <Dialog
        v-model:visible="visible"
        header="Build your plan"
        @afterHide="emits('closed')"
        modal
        class="w-96"
    >
          <FloatLabel class="w-full">
              <Select v-model="selected_template"
                      filter
                      option-value="id"
                      :options="templates" optionLabel="name" class="w-full"/>
              <label for="over_label">Templates</label>
          </FloatLabel>

        <RippleButton @click="clone_template" type="submit" class="md:block mt-4 w-full">Add</RippleButton>
    </Dialog>

</template>

<style scoped>

</style>
