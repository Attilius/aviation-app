<script setup>
import { onMounted, ref } from 'vue';
import InputErrorLabelSetter from '../Utils/InputErrorLabelSetter.js';
import InputLabelPositionAndSizeSetter from '../Utils/InputLabelPositionAndSizeSetter.js';

const props = defineProps({
    modelValue: String,
    id: String,
    label: Object,
    customClasses: Array,
    optionType: Object,
    counter: {
        type: Number,
        default: null
    },
    error: String
});

const emit = defineEmits(['update:modelValue', 'updateInputError']);

const select = ref(null);

onMounted(() => {
    if (select.value.hasAttribute('autofocus')) {
        select.value.focus();
    }
    setLabelPositionAndSize();
});

const inputErrorSetter = new InputErrorLabelSetter();

inputErrorSetter.set(props, 'travel_type');

/**
 * Set the position and size of the label when the associated input field contains a value.
 */
const setLabelPositionAndSize = () => {
    const labelPositionSetter = new InputLabelPositionAndSizeSetter();

    labelPositionSetter.set();
}

defineExpose({ focus: () => select.value.focus() });
</script>

<template>
    <div class="relative p-0 bg-transparent border-none">
        <select :id="id"
                ref="select"
                class="relative h-8 w-full border-none input-border-outline capitalize
                      bg-transparent py-0 focus:ring-transparent transition-colors z-10
                      peer duration-500"
                :class="customClasses"
                :value="modelValue"
                @change="emit('update:modelValue', $event.target.value);
                         emit('updateInputError', ['', props.id]);
                         setLabelPositionAndSize();"
        >
                <option v-if="modelValue" :value="modelValue" hidden selected>{{ modelValue }}</option>
                <option v-else value="" hidden selected></option>
                <option v-for="value in optionType" :value="value.value">
                    {{ value.text }}
                </option>
        </select>
        <label :id="label.id"
               :for="label._for_"
               class="absolute left-2 px-1 -top-0.5 text-md cursor-text peer-focus:text-xs peer-focus:-top-4
                      transition-all duration-500"
               :class="label.customClasses">
            {{ counter !== null ?  label.textValue + ' ' + counter + ' *' : label.textValue }}
        </label>
    </div>
</template>
