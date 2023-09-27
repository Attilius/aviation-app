<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '../../Layouts/AppLayout.vue';

const props = defineProps({
    favoritePlaces: Object,
    title: String
});
const favoritePlacesDataAmount = Object.keys(props.favoritePlaces).length;

const isHaveServiceType = (serviceType) => {
    let result = false;

    props.favoritePlaces.forEach((favoritePlace)=> {
        if(Object.values(favoritePlace).includes(serviceType)){
            result = true;
        }
    });

    return result;
}
</script>

<template>
    <Head :title="title">
        <title></title>
    </Head>

    <AppLayout :title="title">
        <header class="pt-22 pb-10 text-center text-whitesmoke text-xl sm:text-4xl font-bold text-shadow bg-info">
            My favorite places
        </header>

        <div v-if=" ! favoritePlacesDataAmount " class="max-w-7xl h-auto mx-auto py-10 md:px-6 lg:px-8">
            <h1 class="mt-20 my-52 pl-14 text-custom_blue text-lg font-medium">There is no have favorite places yet</h1>
        </div>

        <div v-else class="max-w-7xl h-auto py-18 md:px-6 lg:px-8">

            <!-- Attraction service list -->

            <div v-if="isHaveServiceType('attraction')">
                <h1 class="w-9/1 mx-auto md:mx-0 md:w-1/2 bg-info text-xl text-center md:text-start md:text-3xl
                           text-whitesmoke text-shadow font-bold py-1 pl-0 md:pl-2 rounded-lg uppercase italic"
                >
                    Attractions
                </h1>
                <div v-for="favoritePlace in favoritePlaces" :key="favoritePlace.id">
                    <div v-if="favoritePlace.service_type === 'attraction'"
                         class="flex w-full md:w-1/2 border-2 rounded-lg p-2 my-2 m-0 md:ml-6 shadow-md"
                    >
                        <img class="w-1/4" :src="favoritePlace.service_image" alt="image of place">
                        <h2 class="text-shadow p-2 text-white absolute left-2 md:left-16 my-0
                                   text-sm font-semibold"
                        >
                            {{ favoritePlace.city_name }}
                        </h2>
                        <div class="pl-2 my-auto">
                            <p class="text-custom_blue font-medium">{{ favoritePlace.service_name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hotel service list -->

            <div v-if="isHaveServiceType('hotel')">
                <h1 class="w-9/1 mx-auto md:mx-0 md:w-1/2 bg-info text-xl text-center md:text-start md:text-3xl
                           text-whitesmoke text-shadow font-bold py-1 pl-0 md:pl-2 rounded-lg uppercase italic"
                >
                    Hotels
                </h1>
                <div v-for="favoritePlace in favoritePlaces" :key="favoritePlace.id">
                    <div v-if="favoritePlace.service_type === 'hotel'"
                         class="flex w-full md:w-1/2 border-2 rounded-lg p-2 my-2 m-0 md:ml-6 shadow-md"
                    >
                        <img class="w-1/4" :src="favoritePlace.service_image" alt="image of place">
                        <h2 class="text-shadow p-2 text-white absolute left-2 md:left-16 my-0
                                   text-sm font-semibold"
                        >
                            {{ favoritePlace.city_name }}
                        </h2>
                        <div class="pl-2 my-auto">
                            <p class="text-custom_blue font-medium">{{ favoritePlace.service_name }}</p>
                            <p class="text-custom_blue text-sm">{{ favoritePlace.service_address }}</p>
                            <p class="text-custom_blue text-sm">{{ favoritePlace.service_phone }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Restaurant service list -->

            <div v-if="isHaveServiceType('restaurant')">
                <h1 class="w-9/1 mx-auto md:mx-0 md:w-1/2 bg-info text-xl text-center md:text-start md:text-3xl
                           text-whitesmoke text-shadow font-bold py-1 pl-0 md:pl-2 rounded-lg uppercase italic"
                >
                    Restaurants
                </h1>
                <div v-for="favoritePlace in favoritePlaces" :key="favoritePlace.id">
                    <div v-if="favoritePlace.service_type === 'restaurant'"
                         class="flex w-full md:w-1/2 border-2 rounded-lg p-2 my-2 m-0 md:ml-6 shadow-md"
                    >
                        <img class="w-1/4" :src="favoritePlace.service_image" alt="image of place">
                        <h2 class="text-shadow p-2 text-white absolute left-2 md:left-16 my-0
                                   text-sm font-semibold"
                        >
                            {{ favoritePlace.city_name }}
                        </h2>
                        <div class="pl-2 my-auto">
                            <p class="text-custom_blue font-medium">{{ favoritePlace.service_name }}</p>
                            <p class="text-custom_blue text-sm">{{ favoritePlace.service_address }}</p>
                            <p class="text-custom_blue text-sm">{{ favoritePlace.service_phone }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </AppLayout>
</template>
