<script setup>
import BookingForm from "../Pages/Booking/BookingForm.vue";
</script>

<template>
    <div class="content pt-16">
        <div class="under-left">
            <div class="bg-welcomeHeader left">
                <div class="cover-bg">
                    <img
                        class="A320"
                        src="/img/airplanes/A320.png"
                        alt="Plane"
                    >
                </div>
            </div>
        </div>
        <div class="pl-16 right">
            <div class="open-page-content">
                <h2 class="title-top leading-15">
                    Make your trip an <b>experience</b>
                </h2>
                <h2 class="title-bottom pt-5">fly with us</h2>

                <BookingForm />

            </div>
        </div>
    </div>
</template>
