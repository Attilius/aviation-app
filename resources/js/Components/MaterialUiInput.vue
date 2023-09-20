<script setup>
import { onMounted, ref } from 'vue';
import { CssClassModifier } from "../Utils/CssClassModifier.js";
import InputErrorLabelSetter from '../Utils/InputErrorLabelSetter.js';
import InputLabelPositionAndSizeSetter from '../Utils/InputLabelPositionAndSizeSetter.js';

const props = defineProps({
    modelValue: String,
    id: String,
    type: String,
    label: Object,
    customClasses: Array,
    error: String,
    inputValueStatus: String,
    _for_: String
});

const emit = defineEmits(['update:modelValue', 'updateInputError']);
const input = ref(null);
let inputBaseCssClasses = `relative h-8 w-full border-none input-border-outline p-0 bg-transparent
    focus:ring-transparent transition-colors z-10 peer`;

let labelBaseCssClasses = `absolute left-2 px-1 -top-0.5 text-md cursor-text peer-focus:text-xs peer-focus:-top-4
    transition-all duration-500`;

const cssClassModifier = new CssClassModifier();
const inputErrorSetter = new InputErrorLabelSetter();

inputErrorSetter.set(props, 'departure_from');
inputErrorSetter.set(props, 'arriving_at');
inputErrorSetter.set(props, 'departure_date');
inputErrorSetter.set(props, 'return_date');

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
        <input data-testId="mui-input"
               :type="type"
               :id="id"
               ref="input"
               :class="cssClassModifier.classAttributeExpander(inputBaseCssClasses, customClasses)"
               autocomplete="off"
               required
               :value="modelValue"
               @input="emit('update:modelValue', $event.target.value);
                       emit('updateInputError', ['', props.id]);
                       setLabelPositionAndSize();"
        >
        <label data-testId="mui-label"
               :id="label.id"
               :for="_for_ ? label._for_ + _for_ : label._for_"
               :class="cssClassModifier.classAttributeExpander(labelBaseCssClasses, label.customClasses)">
               {{ label.textValue }}
        </label>
    </div>
</template>
