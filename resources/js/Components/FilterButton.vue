<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button data-testId="primary-button"
            :type="type"
            class="rounded-full items-center px-4 py-2 bg-transparent border
                   border-rebecca_purple font-semibold text-xs text-dark uppercase tracking-widest
                   hover:bg-textGray disabled:opacity-25 smooth-transition hover:duration-500"
    >
        <slot />
        <font-awesome-icon class="pl-2" :icon="['fas', 'caret-down']" />
    </button>
</template>
