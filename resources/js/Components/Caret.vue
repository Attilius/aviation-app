<script setup>
import { computed, onMounted, ref, watch } from "vue";

const props = defineProps({
    id: String,
    _class: {
        type: String,
        defaul: 'ml-5 cursor-pointer h-5 w-5'
    }
});

const emit = defineEmits(['updateState']);

const icon = ref(['fas', 'angle-down']);
const state = ref('closed');

const getState = computed(() => state.value);
const setState = computed({
    set(val) {
        state.value = val;
    }
});

const modifyIcon = computed({
    set(val) {
        icon.value = val;
    }
});

onMounted(() => {
    const caret = document.getElementById(props.id);

    caret.addEventListener('click', () => {
        if(caret.id !== 'caret') {
            setState.value = (getState.value === 'closed') ? 'opened' : 'closed';
        }
    });
});

watch(getState, (newState) => {
    modifyIcon.value = (newState === 'opened') ? ['fas', 'angle-up'] : ['fas', 'angle-down'];
    emit('updateState', {
        id: props.id,
        state: getState.value
    })
});
</script>

<template>
    <font-awesome-icon :id="id"
                       :class="_class"
                       :icon="icon"
    />
</template>

