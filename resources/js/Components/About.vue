<script setup>
import FeedbacksCarousel from "./FeedbacksCarousel.vue";
import CounterContainer from '../Components/CounterContainer.vue';
import counterData from '../Config/counterData.js';
import JsonDataProvider from "../Utils/JsonDataProvider";

const partnerImages = new JsonDataProvider('partners', 'img').getData();

</script>

<template>
    <div>
        <div class="about-content-header">
            <div class="color-box">
                <h1>Aviation is our passion</h1>
                <img
                    class="B737"
                    :src="'img/airplanes/B737.png'"
                    alt="Plane"
                >
            </div>
        </div>

        <div class="about-content">
            <div class="main-content">
                <div class="top">
                    <div class="upper">
                        <img
                            class="office"
                            :src="'img/about/office.jpg'"
                            alt="Office"
                        >
                        <div class="text-content">
                            <h3>About us</h3>
                            <article>
                                Our company is the result of a recently formed
                                airline partnership. Initially, we only
                                supported our market-leading peers by providing
                                ancillary flights. We now offer our own routes
                                to customers who want to travel. We also operate
                                charter flights to many destinations around the
                                world. We work with our colleagues on a daily
                                basis to provide a tailor-made solution for each
                                of our customers. Whether it's a business trip
                                or a holiday, all you need to do is choose a
                                destination and a date, leave the rest to us!
                            </article>
                        </div>
                    </div>
                    <div class="center">
                        <img
                            class="pilot"
                            :src="'img/about/pilot.jpg'"
                            alt="Pilot"
                        >
                        <div class="text-content">
                            <article>
                                With years of experience and thousands of hours
                                flown, our experienced pilots guarantee the
                                safety of our passengers. We develop them
                                through a variety of training courses. They
                                demonstrate their confident skills day in, day
                                out, in small and large aircraft.
                            </article>
                        </div>
                    </div>
                    <div class="under">
                        <img
                            class="stewardess"
                            :src="'img/about/stewardess.jpg'"
                            alt="Stewardess"
                        >
                        <div class="text-content">
                            <article>
                                Our friendly and helpful cabin crew will ensure
                                the comfort of our passengers. They will do
                                their utmost to make your journey, even if it
                                takes several hours, a pleasant one.
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="img-box bg-aboutImageBox bg-cover bg-fixed bg-center">
            <div class="about-skin">
                <h3 class="text-3xl text-whitesmoke">Our partners</h3>
                <div class="slider_">
                    <div class="slide-track">
                        <div v-for="data in partnerImages" class="slide_">
                            <img class="img" :src="data" alt="partner-logo" />
                        </div>
                        <div v-for="data in partnerImages" class="slide_">
                            <img class="img" :src="data" alt="partner-logo" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bottom-box bg-aboutBottomBox bg-cover bg-no-repeat bg-center">
            <div class="about-skin pb-20">
                <section class="counters py-10">
                    <h3 class="text-3xl">More than...</h3>
                   <div
                        id="counters-container"
                        class="container"
                    >
                       <CounterContainer
                           v-for="data in counterData.counters"
                           :icon="data.icon"
                           :title="data.title"
                           :target="data.target"
                       />
                   </div>
                </section>

                <FeedbacksCarousel />

            </div>
        </div>
    </div>
</template>

<style>
.slider_ {
    height: 100px;
    position: relative;
    width: 100%;
    display: grid;
    place-items: center;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.9);
}

.slide-track {
    display: flex;
    width: calc(250px * 24);
    animation: scroll 40s linear infinite;
}

.slide_ {
    height: 100px;
    width: 250px;
    display: flex;
    align-items: center;
    padding: 15px;
}

.img {
    width: 100%;
}

@keyframes scroll {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(calc(-250px * 12));
    }
}
</style>
