<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '../../Layouts/AppLayout.vue';
import AnimatedHeader from '../../Components/AnimatedHeader.vue';
import SectionBorder from '../../Components/SectionBorder.vue';
import Booking from "../Booking/Booking.vue";

const props = defineProps({
    title: String,
    headerImageTitles: Object,
    styles: Array,
    description: String,
    categories: Array,
    airports: Array,
    isPrivate:Boolean
});

</script>

<template>

    <Head :title="title">
        <title></title>
    </Head>

    <AppLayout :title="title">
        <div class="w-full bg-services bg-cover bg-no-repeat">
            <div class="w-full bg-custom-blue-alfa-8 flex-col justify-around">
                <div class="container h-auto w-full lg:w-4/5.2 lg:h-[calc(100vh+450px)] xl:h-[calc(100vh+500px)]
                            2xl:h-[calc(100vh+400px)] flex-col
                            justify-center align-middle px-5 mx-auto"
                >
                    <AnimatedHeader :headerImageTitles="headerImageTitles" :styles="styles" />
                    <h2 class="w-full text-whitesmoke text-2xl sm:text-3xl lg:text-4xl 2xl:text-5xl pt-10 px-0 pb-2
                               mt-10 lg:relative lg:top-125 capitalize text-center lg:text-start text-shadow
                               after:content-[''] after:absolute after:w-1/10 after:bg-lightskyblue after:h-0.5
                               lg:after:h-1 2xl:after:h-2 after:top-28 md:after:top-30 lg:after:top-22 2xl:after:top-26
                               after:left-1/15 lg:after:left-0 after:mb-5 after:rounded-full after:shadow-3xl"
                    >
                        {{ title }}
                    </h2>
                    <article class="w-full text-textGray text-xs lg:text-base lg:relative lg:top-125
                                    2xl:top-133 px-0 py-6 mx-0 pb-10 lg:pb-20"
                    >
                        {{ description }}

                        <SectionBorder />

                    </article>

                    <!-- Private Booking Form -->

                    <Booking class_="booking-form-private"
                             btn_text="Search airplane"
                             :airports="airports"
                             :isPrivate="isPrivate"
                    />

                </div>
            </div>
        </div>
    </AppLayout>

</template>
