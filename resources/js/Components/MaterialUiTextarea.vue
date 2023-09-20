<script setup>
import { onMounted, ref } from 'vue';
import { CssClassModifier } from "../Utils/CssClassModifier.js";
import InputLabelPositionAndSizeSetter from '../Utils/InputLabelPositionAndSizeSetter.js';

defineProps({
    modelValue: String,
    id: String,
    name: String,
    rows: String,
    cols: String,
    maxlength: String,
    label: Object,
    customClasses: Array,
});

defineEmits(['update:modelValue']);

const input = ref(null);

let inputBaseCssClasses = `relative h-38 w-full border-t-0 border-l-0 border-r-0 border-b-2 input-border-outline
    bg-transparent focus:ring-transparent transition-colors z-10 peer duration-500`;

let labelBaseCssClasses = `absolute left-2 px-1 -top-0.5 text-md cursor-text peer-focus:text-xs peer-focus:-top-4
    transition-all duration-500`;

const cssClassModifier = new CssClassModifier();

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
    const labelPositionSetter = new InputLabelPositionAndSizeSetter();

    labelPositionSetter.set();
}

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="relative p-0 bg-transparent border-none">
        <textarea data-testId="mui-textarea"
               :name="name"
               :id="id"
               :rows="rows"
               :cols="cols"
               :maxlength="maxlength"
               ref="input"
               :class="cssClassModifier.classAttributeExpander(inputBaseCssClasses, customClasses)"
               required
               :value="modelValue"
               @input="$emit('update:modelValue', $event.target.value); setLabelPositionAndSize();">
        </textarea>
        <label data-testId="mui-label"
               :for="label._for_"
               :class="cssClassModifier.classAttributeExpander(labelBaseCssClasses, label.customClasses)">
            {{ label.textValue }}
        </label>
    </div>
</template>
