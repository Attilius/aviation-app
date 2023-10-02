<script setup>
import HeaderFront from '../../../Components/TravelGuide/Destination/HeaderFront.vue';

const props = defineProps({
    destination: Object,
    currentTime: String
});
</script>

<template>
    <div>
        <div class="w-full h-screen bg-cover bg-no-repeat text-whitesmoke relative top-0"
             :class="destination.header_image_css">
            <HeaderFront :destination="destination" :currentTime="currentTime" />
        </div>
    </div>
</template>
