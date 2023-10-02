<script setup>
defineProps({
   title: String
});
</script>

<template>
    <div class="h-16 bg-white-alfa-8 pt-2 px-3 absolute top-24 left-1/20 text-custom_blue text-5xl mt-48 text-center"
    >
        <h3>{{ title }}</h3>
    </div>
</template>
