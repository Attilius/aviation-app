<script setup>
import HeaderInformationDatas from '../../../Components/TravelGuide/Destination/HeaderInformationDatas.vue';
import BookingButton from '../../../Components/TravelGuide/Destination/BookingButton.vue';
import Pointer from '../../../Components/TravelGuide/Destination/Pointer.vue';

const props = defineProps({
    destination: Object,
    currentTime: String
})

</script>

<template>
    <div>
        <div class="head-box">
            <div class="skin">
                <h5 class="text-2xl p-5 capitalize">{{ destination.country }}</h5>
                <h3 class="text-5xl">{{ destination.city.name.replace('-', ' ') }}</h3>
                <HeaderInformationDatas :destination="destination" :currentTime="currentTime" />
                <BookingButton :city="destination.city" />
                <Pointer />
            </div>
        </div>
    </div>
</template>

<style scoped>
.head-box .skin {
    height: 100vh;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.skin {
    background: rgba(5, 16, 57, 0.5);
}

.head-box h3 {
    text-transform: uppercase;
    font-weight: 600;
    margin-top: 5px;
}
</style>
