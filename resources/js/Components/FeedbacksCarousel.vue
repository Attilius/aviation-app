<script setup>
import { onMounted } from 'vue';
import { initFlowbite } from 'flowbite';
import Rating from '../Components/Rating.vue';
import JsonToArrayTransformer from '../Utils/JsonToArrayTransformer.js';
import feedbacks from '../../data/feedbacks.json';

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
});

// Get data for carousel
const feedbacksData = new JsonToArrayTransformer(feedbacks).transform();

</script>

<template>
    <!-- This is an example component -->
    <div class="max-w-2xl mx-auto w-full z-0">

        <div id="default-carousel" class="relative flex justify-center" data-carousel="slide">
            <!-- Carousel wrapper -->
            <div class="slide overflow-hidden relative h-56 sm:h-64 xl:h-72 2xl:h-80 rounded-lg ">

                <!-- Slide item -->

                <div v-for="feedback in feedbacksData"
                     :key="feedback.name"
                     id="carousel-indicator-1"
                     class="slide-card hidden duration-700 ease-in-out"
                     data-carousel-item
                >
                    <div class="slide-top">
                        <img
                            :src=feedback.src
                            class="slide-img"
                            :alt=feedback.alt>
                        <div class="flex flex-col justify-center">
                            <h4 class="customer-name">
                                {{ feedback.name }}
                            </h4>
                            <Rating ratingNumber="5.0" />
                        </div>
                    </div>

                    <p class="comment">
                        <font-awesome-icon :icon="['fas', 'quote-left']" class="text-xs" />
                        {{ feedback.comment }}
                        <font-awesome-icon :icon="['fas', 'quote-right']" class="text-xs" />
                    </p>

                </div>
            </div>

            <!-- Slider indicators -->

            <div class="flex absolute bottom-5 left-1/2 z-30 space-x-3 -translate-x-1/2">
                <button
                    v-for="(index) in feedbacksData"
                    type="button"
                    class="w-3 h-3 rounded-full"
                    aria-current="false"
                    :aria-label="'Slide ' + index+1"
                    :data-carousel-slide-to=index
                >
                </button>
            </div>

            <!-- Slider controls -->

            <button type="button" class="flex absolute top-0 left-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                <span class="hidden">Previous</span>
            </span>
            </button>
            <button type="button" class="flex absolute top-0 right-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none" data-carousel-next>
            <span class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="hidden">Next</span>
            </span>
            </button>
        </div>
    </div>
</template>
