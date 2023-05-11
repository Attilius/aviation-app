<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button data-testId="primary-button"
            :type="type"
            class="rounded-full inline-flex items-center px-4 py-2 bg-rebecca_purple border
                   border-transparent font-semibold text-xs text-whitesmoke uppercase tracking-widest
                   hover:bg-whitesmoke hover:text-rebecca_purple hover:border-rebecca_purple active:bg-gray-900
                   focus:outline-none focus:border-gray-900 focus:ring focus:ring-light_purple disabled:opacity-25
                   smooth-transition hover:duration-500"
    >
        <slot />
    </button>
</template>
