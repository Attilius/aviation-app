<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { passengers } from "../../Config/selectOption.js";
import AppLayout from '../../Layouts/AppLayout.vue';
import AnimatedHeader from '../../Components/AnimatedHeader.vue';
import SectionBorder from '../../Components/SectionBorder.vue';
import BookingForm from "../Booking/BookingForm.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import SecondaryButton from "../../Components/SecondaryButton.vue";
import MaterialUiSelect from '../../Components/MaterialUiSelect.vue';
import InputAttributesBuilder from "../../Utils/InputAttributesBuilder";

defineProps({
    title: String,
    headerImageTitles: Object,
    styles: Array,
    description: String,
    tableHeadFields: Array,
    categories: Array,
    airports: Array,
    btn_text: String,
    currentReservationId: String,
    isPrivate:Boolean
});

const form = useForm({
    passengers: [
        {
            id: 1,
            type: 'Adult'
        }
    ],
    addPassengerBoxState: 'hidden',
    passengersFieldValue: '1 adult'
});

const inputAttributes = new InputAttributesBuilder('addPassenger').build();

const setPassengers = () => {
    const filteredAdultPassengers = form.passengers.filter(passenger => {
        return passenger.type === 'Adult';
    });
    const filteredSeniorPassengers = form.passengers.filter(passenger => {
        return passenger.type === 'Senior (65 years and Older)';
    });
    const filteredYouthPassengers = form.passengers.filter(passenger => {
        return passenger.type === 'Youth (12 - 17 years)';
    });

    if (filteredAdultPassengers.length === form.passengers.length && form.passengers.length === 1) {
        form.passengersFieldValue = '1 adult'
    } else if (filteredAdultPassengers.length === form.passengers.length) {
        form.passengersFieldValue = form.passengers.length.toString() + ' adults';
    } else if (filteredSeniorPassengers.length === form.passengers.length && form.passengers.length === 1) {
        form.passengersFieldValue = '1 senior'
    } else if (filteredSeniorPassengers.length === form.passengers.length) {
        form.passengersFieldValue = form.passengers.length.toString() + ' seniors';
    } else if (filteredYouthPassengers.length === form.passengers.length && form.passengers.length === 1) {
        form.passengersFieldValue = '1 youth'
    } else if (filteredYouthPassengers.length === form.passengers.length) {
        form.passengersFieldValue = form.passengers.length.toString() + ' youths';
    } else {
        form.passengersFieldValue = form.passengers.length.toString() + ' passengers';
    }

    document.body.classList.remove('stop-scrolling');
    form.addPassengerBoxState = 'hidden';
}

const addPassenger = () => {
    form.passengers.push(
        {
            id: form.passengers.length + 1,
            type: 'Adult'
        }
    )
}

const removePassenger = (event) => {
    const index = form.passengers.indexOf(form.passengers[event.target.id-1]);

    form.passengers.splice(index, 1);
    form.passengers.forEach((item, index) => {
        item.id = index + 1;
    });
}

function setAddPassengerBoxState (state) {
    form.addPassengerBoxState = state;
}

function resetPassengers (passenger) {
    form.passengers = passenger;
}

</script>

<template>

    <Head :title="title">
        <title></title>
    </Head>

    <AppLayout :title="title">
        <div class="w-full bg-services bg-cover bg-no-repeat">
            <div class="w-full bg-custom-blue-alfa-8 flex-col justify-around">
                <div class="container h-auto lg:w-4/5.2 lg:h-[calc(100vh+450px)] xl:h-[calc(100vh+500px)]
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
                                    2xl:top-133 px-0 py-6 mx-0"
                    >
                        {{ description }}

                        <SectionBorder />

                    </article>

                    <!-- Private Booking Form -->

                    <BookingForm class="w-full relative top-1/2 bottom-5 shadow-3xl"
                                 class_="booking-form-private"
                                 btn_text="Search airplane"
                                 :isPrivate="isPrivate"
                                 :airports="airports"
                                 :passengers="form.passengers"
                                 :valueOfPassengersField="form.passengersFieldValue"
                                 :currentReservationId="currentReservationId"
                                 @updateAddPassengerBoxState="setAddPassengerBoxState"
                                 @updatePassengers="resetPassengers"
                    />

                    <!-- Add new passenger box -->

                    <div id="add-passengers"
                         class="w-full md:w-2/3 lg:w-1/3 h-2/3 bg-whitesmoke z-10 shadow-3xl fix-screen-center flex-col
                                pointer-events-auto"
                         :class="form.addPassengerBoxState"
                    >
                        <div class="w-full h-4/5.2 container border-b border-textGray px-3 py-4 flex-col">
                            <h1 class="text-xl sm:text-2xl lg:text-3xl font-semibold text-custom_blue">
                                Passengers ({{ form.passengers.length }})
                            </h1>
                            <div class="h-9/1"
                                :class="form.passengers.length > 1 ? 'overflow-y-scroll' : ''"
                            >
                                <div :id="passenger.id"  v-for="passenger in form.passengers" :key="passenger.id"
                                      class="w-full h-30 border border-textGray mt-5 flex justify-around items-center">
                                    <font-awesome-icon :icon="['fas', 'circle-user']"
                                                       class="text-custom_blue text-4xl"
                                    />
                                    <div class="flex border-b-2 pb-0.25 border-custom_blue"
                                         :class="form.passengers.length > 1 ? 'w-2/3' : 'w-4/5.2'"
                                    >
                                        <MaterialUiSelect
                                            :id="inputAttributes.passenger.id"
                                            v-model="passenger.type"
                                            class="mt-1 block w-full"
                                            :customClasses="inputAttributes.passenger.customClasses"
                                            :label="inputAttributes.passenger.label"
                                            :optionType="passengers"
                                            :counter="passenger.id"
                                        />
                                    </div>
                                    <div class="h-full">
                                        <font-awesome-icon :id="passenger.id"
                                                           class="text-custom_blue text-xl float-right mt-1
                                                              rounded-full pt-2 cursor-pointer"
                                                           :class="form.passengers.length > 1 ? 'block' : 'hidden'"
                                                           :icon="['fas', 'xmark']"
                                                           @click="removePassenger"
                                        />
                                    </div>
                                </div>
                                <SecondaryButton class="mt-5" @click="addPassenger()">
                                    <span class="text-2xl mr-2">+</span> Add a passenger
                                </SecondaryButton>
                            </div>
                        </div>
                        <div class="w-full h-1/4 pb-10 pr-5 flex justify-end items-center">
                            <PrimaryButton class="" @click="setPassengers()">
                                {{ btn_text ? btn_text : 'Continue' }}
                            </PrimaryButton>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>

</template>

<style scoped>
.fix-screen-center {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.pointer-events-auto {
    pointer-events: auto;
}
</style>
