<script setup>

const props = defineProps({
    error: String,
    inputValueStatus: String,
    modelValue: String,
    id: String
});

const emit = defineEmits(['updateModelValue']);

</script>

<template>
    <div :id="id" @click="emit('updateModelValue', ['', id])"
         class="w-8 h-8 cursor-pointer flex justify-center items-center mt-1">
        <font-awesome-icon id="remove-icon"
                           :icon="['fas', 'xmark']"
                           class="text-lg block"
                           :class="error !== '' || inputValueStatus === '' ? 'hidden': 'block'"
        />
    </div>
</template>

