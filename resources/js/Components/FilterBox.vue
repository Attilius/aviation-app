<script setup>
import SecondaryButton from "../Components/SecondaryButton.vue";
import { ref, watch } from "vue";

const props = defineProps({
    id: String,
    maximumPrice: Number,
    minimumPrice: Number,
    fullAirplanes: Array,
    filteredAirplanes: Array
});

const emit = defineEmits(['updateAirplanes']);

const sliderValue = ref(props.maximumPrice);
const slider = ref(null);
let price = props.maximumPrice;

watch(sliderValue, (newValue, oldValue) => {
    price = newValue;
    if(newValue < oldValue) {
        const filteredAirplanes = props.filteredAirplanes.filter(airport => airport.price <= newValue);
        emit('updateAirplanes', filteredAirplanes);
    } else {
        const filteredAirplanes = props.fullAirplanes.filter(airport => airport.price <= newValue);
        emit('updateAirplanes', filteredAirplanes);
    }
});

const close = () => {
    document.getElementById('price-filter').classList.replace('block', 'hidden');
}

</script>

<template>
    <div :id="id" class="w-1/2 lg:w-1/3 h-full hidden bg-whitesmoke absolute top-44 left-26 shadow-3xl z-10">
        <div class="w-full h-10 flex justify-between items-center px-3">
            <h4 class="inline text-custom_blue text-xl font-semibold">Price</h4>
            <font-awesome-icon class="text-custom_blue text-xl float-right rounded-full cursor-pointer"
                               :icon="['fas', 'xmark']"
                               @click="close()"
            />
        </div>
        <p class="text-custom_blue text-xs lg:text-sm px-3">Maximum price: {{ price }} USD</p>
        <div class="flex justify-center items-center my-10 custom-slider">
            <input type="range" :min="minimumPrice" :max="maximumPrice" v-model="sliderValue"
                   class="w-9/1 slider"
            />
        </div>
        <SecondaryButton class="uppercase float-right text-info text-xs lg:text-lg mr-2 mb-2 hover:bg-transparent
                                cursor-default"
        >
            <span class="text-xs lg:text-lg mx-2">{{ props.filteredAirplanes.length }}</span> result
        </SecondaryButton>
    </div>
</template>

<style scoped>
.custom-slider {
    --trackHeight: 2px;
    --thumbRadius: 1.2rem;
}

/* style the input element with type "range" */
.custom-slider input[type="range"] {
    position: relative;
    appearance: none;
    /* pointer-events: none; */
    border-radius: 999px;
    z-index: 0;
}

/* ::before element to replace the slider track */
.custom-slider input[type="range"]::before {
    content: "";
    position: absolute;
    background: white;
    /* z-index: -1; */
    pointer-events: none;
    border-radius: 999px;
}

/* `::-webkit-slider-runnable-track` targets the track (background) of a range slider in chrome and safari browsers. */
.custom-slider input[type="range"]::-webkit-slider-runnable-track {
    appearance: none;
    background: #093773;
    height: var(--trackHeight);
    border-radius: 999px;
}

/* `::-moz-range-track` targets the track (background) of a range slider in Mozilla Firefox. */
.custom-slider input[type="range"]::-moz-range-track {
    appearance: none;
    background: #093773;
    height: var(--trackHeight);
    border-radius: 999px;
}

.custom-slider input[type="range"]::-webkit-slider-thumb {
    position: relative;
    top: 50%;
    transform: translate(0, -50%);
    width: var(--thumbRadius);
    height: var(--thumbRadius);
    /* margin-top: calc((var(--trackHeight) - var(--thumbRadius)) / 2); */
    background: #093773;
    border-radius: 999px;
    pointer-events: all;
    appearance: none;
    z-index: 1;
}
</style>
