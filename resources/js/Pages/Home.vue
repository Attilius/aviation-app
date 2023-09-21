<script setup>
import { computed, onMounted, ref } from "vue";
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '../Layouts/AppLayout.vue';
import HomeHeader from '../Components/HomeHeader.vue';
import PrimaryButton from '../Components/PrimaryButton.vue';
import ArrayToStringTransformer from "../Utils/ArrayToStringTransformer";

defineProps({
    title: String,
});

const topDestinations = ref([
    {
        id: 1,
        country: 'greece',
        city: 'athens',
        price: 150,
        image: ['bg-athens']
    },
    {
        id: 2,
        country: 'spain',
        city: 'barcelona',
        price: 160,
        image: ['bg-barcelona']
    },
    {
        id: 3,
        country: 'egypt',
        city: 'cairo',
        price: 935,
        image: ['bg-cairo']
    },
    {
        id: 4,
        country: 'turkey',
        city: 'istanbul',
        price: 180,
        image: ['bg-istanbul']
    },
]);

const setTopDestinations = computed({
    set(val) {
        topDestinations.value = val;
    }
});

const form = useForm({
    city: ''
});
const goDestination = (cityName) => {
    form.city = cityName;
    form.get(route('show-city'));
}

onMounted(() => {
    setTopDestinations.value = destinations();
});

let cardBaseCssClasses = `card bg-cover bg-center`;

const classAttributeExpander = (baseCssClasses, customClasses) => {
    if (customClasses) {
        const transformedArray = new ArrayToStringTransformer(customClasses).transform();
        baseCssClasses += " " + transformedArray;
    }

    return baseCssClasses;
}

const destinations = () => {
    const amountOfTopDestinations = 4;
    const result = [];
    const destinations = [
        {
            id: 1,
            country: 'greece',
            city: 'Athens',
            price: 150,
            image: ['bg-athens']
        },
        {
            id: 2,
            country: 'spain',
            city: 'Barcelona',
            price: 160,
            image: ['bg-barcelona']
        },
        {
            id: 3,
            country: 'egypt',
            city: 'Cairo',
            price: 935,
            image: ['bg-cairo']
        },
        {
            id: 4,
            country: 'turkey',
            city: 'Istanbul',
            price: 180,
            image: ['bg-istanbul']
        },
        {
            id: 5,
            country: 'portugal',
            city: 'Lisbon',
            price: 160,
            image: ['bg-lisbon']
        },
        {
            id: 6,
            country: 'united kingdom',
            city: 'London',
            price: 159,
            image: ['bg-london']
        },
        {
            id: 7,
            country: 'canada',
            city: 'Montreal',
            price: 535,
            image: ['bg-montreal']
        },
        {
            id: 8,
            country: 'germany',
            city: 'Munich',
            price: 170,
            image: ['bg-munich']
        },
        {
            id: 9,
            country: 'united states of america',
            city: 'New-York',
            price: 497,
            image: ['bg-new_york']
        },
        {
            id: 10,
            country: 'france',
            city: 'Paris',
            price: 100,
            image: ['bg-paris']
        },
        {
            id: 11,
            country: 'italy',
            city: 'Rome',
            price: 160,
            image: ['bg-rome']
        },
        {
            id: 12,
            country: 'switzerland',
            city: 'Zurich',
            price: 165,
            image: ['bg-zurich']
        }
];
    let uniqueDestinations = [];

        for (let i = 0; uniqueDestinations.length < amountOfTopDestinations; i++) {
            let index = Math.floor(Math.random() * destinations.length);
            result[i] = destinations[index];
            uniqueDestinations = [...new Set(result)];
        }

    return uniqueDestinations;
}

const goToTravelGuide = () => {
    form.get(route('travel-guide'))
}

</script>

<template>
    <Head>
        <title>Home</title>
    </Head>

    <AppLayout title="Home">
        <div class="">
            <HomeHeader />
            <main class="w-full sm:w-9/12 h-auto mobile">
                <h5 class="main-title">Popular destinations</h5>
                <h6 class="main-subtitle">Explore the world with us</h6>

                <div class="flex-col items-center justify-center">
                    <div class="top-destinations">
                        <div v-for="destination in topDestinations"
                             :key="destination.id"
                             :id="destination.id"
                             :class="classAttributeExpander(cardBaseCssClasses, destination.image)"
                             @click="goDestination(destination.city)"
                        >
                            <h4><span>from</span>${{ destination.price }}</h4>
                            <div class="skin-cover">
                                <h6>{{ destination.country }}</h6>
                                <h5>{{ destination.city.replace('-', ' ') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-auto flex justify-center items-center p-10">
                    <PrimaryButton class="w-54" @click="goToTravelGuide">
                        More destinations
                    </PrimaryButton>
                </div>


                <h5 class="main-title">More than a simple flight</h5>
                <h6 class="main-subtitle">Reserve a car and hotel room for your travel</h6>

                <div class="other-services mb-10">
                    <div class="car-rent bg-rental_car bg-no-repeat">
                        <a
                            class="skin_"
                            target="_blank"
                            href="https://www.rentalcars.com/"
                        >
                            <h5 class="outer-service-title-car">Rental car</h5>
                        </a>
                    </div>
                    <div class="hotel-booking bg-booking_hotel bg-no-repeat">
                        <a
                            class="skin_"
                            target="_blank"
                            href="https://www.booking.com/"
                        >
                            <h5 class="outer-service-title-hotel">Book hotel</h5>
                        </a>
                    </div>
                </div>

            </main>
        </div>
    </AppLayout>
</template>
