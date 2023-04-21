<script setup xmlns="http://www.w3.org/1999/html">
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
    id: String,
    type: String,
    label: Object,
    customClasses: Array,
    basicValue: String
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
    setLabelPositionAndSize();
});

/**
 * Set the position and size of the label when the associated input field contains a value.
 */
const setLabelPositionAndSize = () => {
    const labels = document.getElementsByTagName('label');
    const inputs = document.getElementsByTagName('input');

    for (let input_item of inputs) {
        for (let label_item of labels) {
            if (input_item.value && input_item.id === label_item.htmlFor) {
                label_item.classList.add('px-2');
                label_item.classList.replace('text-md', 'text-sm');
                label_item.classList.replace('top-2', '-top-4');
            } else if (!input_item.value && input_item.id === label_item.htmlFor) {
                label_item.classList.remove('px-2');
                label_item.classList.replace('text-sm', 'text-md');
                label_item.classList.replace('-top-4', 'top-2');
            }
        }
    }
}

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="relative p-0 bg-transparent border-none">
        <input :type="type"
               :id="id"
               ref="input"
               class="relative h-full w-full border-t-0 border-l-0 border-r-0 input-border-outline
                      bg-transparent py-1 focus:ring-transparent transition-colors z-10
                      peer duration-500"
               :class="customClasses"
               required
               autocomplete="off"
               :value="modelValue"
               @input="$emit('update:modelValue', $event.target.value); setLabelPositionAndSize()">
        <label :for="label._for_"
               class="absolute left-2 top-2 text-md cursor-text peer-focus:text-sm peer-focus:-top-4
                      transition-all duration-500 peer-focus:px-2"
               :class="label.customClasses">
               {{ label.value }}
        </label>
    </div>
</template>

<style>

</style>
