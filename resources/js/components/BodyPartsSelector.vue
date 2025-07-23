<script setup lang="ts">

import {ComboboxAnchor, useFilter} from "reka-ui";
import {TagsInput, TagsInputItemText,TagsInputItemDelete,TagsInputItem,TagsInputInput} from "@/components/ui/tags-input";
import {Combobox, ComboboxItem, ComboboxList,ComboboxInput,ComboboxEmpty,ComboboxGroup} from "@/components/ui/combobox";
import {computed, ref} from "vue";
import {BodyPart} from "@/types";


const props = defineProps<{
    bodyParts: BodyPart[]
}>();


const modelValue = ref<string[]>([])
const open = ref(false)
const searchTerm = ref('')

const { contains } = useFilter({ sensitivity: 'base' })
const selectedBodyParts = computed(() => {
    const options = props.bodyParts.filter(i => !modelValue.value.includes(i.name))
    return searchTerm.value ? options.filter(option => contains(option.name, searchTerm.value)) : options
})



const emits =defineEmits(['selected'])
</script>

<template>
    <Combobox multiple  v-model="modelValue" v-model:open="open" :ignore-filter="false" @click="open=true">
        <ComboboxAnchor as-child>
            <TagsInput v-model="modelValue" class="px-2 gap-2 w-fit">
                <div class="flex gap-2 flex-wrap items-center">
                    <TagsInputItem v-for="item in modelValue" :key="item" :value="item">
                        <TagsInputItemText />
                        <TagsInputItemDelete />
                    </TagsInputItem>
                </div>

                <ComboboxInput v-model="searchTerm" as-child>
                    <TagsInputInput placeholder="Body Parts" class="w-full p-0 border-none focus-visible:ring-0 h-auto" @keydown.enter.prevent />
                </ComboboxInput>
            </TagsInput>

            <ComboboxList  class="w-[--reka-popper-anchor-width]">
                <ComboboxEmpty />
                <ComboboxGroup>
                    <ComboboxItem
                        @select="emits('selected', modelValue)"
                        v-for="bodyPart in selectedBodyParts" :key="bodyPart.id" :value="bodyPart.name"
                        @select.prevent="(ev) => {
                          if (typeof ev.detail.value === 'string') {
                            searchTerm = ''
                            modelValue.push(ev.detail.value)
                          }

                          if (selectedBodyParts.length === 0) {
                            open = false
                          }
                        }">
                        {{ bodyPart.name }}
                    </ComboboxItem>
                </ComboboxGroup>
            </ComboboxList>
        </ComboboxAnchor>
    </Combobox>
</template>

<style scoped>

</style>
