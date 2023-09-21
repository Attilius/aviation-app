<script setup>
import BookingForm from "../Pages/Booking/BookingForm.vue";
</script>

<template>
    <div class="content pt-16 border-b-2">
        <div class="under-left">
            <div class="bg-homeHeader left">
                <div class="cover-bg">
                    <img
                        class="A320"
                        src="/img/airplanes/A320.png"
                        alt="Plane"
                    >
                </div>
            </div>
        </div>
        <div class="right bg-transparent">
            <div class="open-page-content">
                <h2 class="title-top leading-15 pl-10 md:text-5xl 2xl:text-6xl">
                    Make your trip an <b>experience</b>
                </h2>
                <h2 class="title-bottom pt-5 pl-10 md:text-5xl 2xl:text-6xl">fly with us</h2>

                <BookingForm class="w-full relative top-1/2 bottom-5 shadow-3xl"
                             class_="booking-form-public"
                />
            </div>
        </div>
    </div>
</template>
