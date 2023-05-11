<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :type="type"
            class="rounded-full inline-flex items-center px-4 py-2 bg-danger border
                   border-transparent font-semibold text-xs text-whitesmoke uppercase tracking-widest
                   hover:bg-whitesmoke hover:text-danger hover:border-danger active:bg-gray-900
                   focus:outline-none focus:border-gray-900 focus:ring focus:ring-light_purple disabled:opacity-25
                   smooth-transition hover:duration-500"
    >
        <slot />
    </button>
</template>
