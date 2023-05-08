<script setup xmlns="http://www.w3.org/1999/html">
import { onMounted, ref } from 'vue';
import ArrayToStringTransformer from '../Utils/ArrayToStringTransformer.js';

defineProps({
    modelValue: String,
    id: String,
    type: String,
    label: Object,
    customClasses: Array,
});

defineEmits(['update:modelValue']);

const input = ref(null);

let inputBaseCssClasses = `relative h-full w-full border-t-0 border-l-0 border-r-0 input-border-outline
    bg-transparent py-1 focus:ring-transparent transition-colors z-10 peer duration-500`;

let labelBaseCssClasses = `absolute left-2 -top-0.5 text-md cursor-text peer-focus:text-xs peer-focus:-top-4
    transition-all duration-500 peer-focus:px-2`;

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
                label_item.classList.replace('text-md', 'text-xs');
                label_item.classList.replace('-top-0.5', '-top-4');
            } else if (!input_item.value && input_item.id === label_item.htmlFor) {
                label_item.classList.replace('text-xs', 'text-md');
                label_item.classList.replace('-top-4', '-top-0.5');
            }
        }
    }
}

const classAttributeExpander = (baseCssClasses, customClasses) => {

    if (customClasses) {
        const transformedArray = new ArrayToStringTransformer(customClasses).transform();
        baseCssClasses += " " + transformedArray;
    }

    return baseCssClasses;
}

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="relative p-0 bg-transparent border-none">
        <input data-testId="mui-input"
               :type="type"
               :id="id"
               ref="input"
               :class="classAttributeExpander(inputBaseCssClasses, customClasses)"
               required
               autocomplete="off"
               :value="modelValue"
               @input="$emit('update:modelValue', $event.target.value); setLabelPositionAndSize();">
        <label data-testId="mui-label"
               :for="label._for_"
               :class="classAttributeExpander(labelBaseCssClasses, label.customClasses)">
               {{ label.textValue }}
        </label>
    </div>
</template>

<style>

</style>
