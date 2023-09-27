<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import Navbar from '../../Components/TravelGuide/Navbar.vue';

const props = defineProps({
    addressesPageContent: Object,
});

const widthOfNavbar = 85 + '%';

const form = useForm({
    city: props.addressesPageContent.cityName.replace(' ', '-')
});

const backToDestination = () => {
    form.get(route('show-city'));
}
</script>

<template>
<div>

    <Head>
        <title>{{ addressesPageContent.name }}</title>
    </Head>

    <div id="wrapper" class="wrapper">
        <div id="addresses-page">
            <Navbar class="navbar_" :width="widthOfNavbar" />

            <div class="content-container">
                <div
                    id="img"
                    class="img"
                    :style="{
                        backgroundImage: `url(${addressesPageContent.image})`
                    }"
                >
                    <div class="bg-shadow-skin w-full h-full">
                        <div class="title mt-28">
                            <h3 class="text-shadow text-lg sm:text-3xl lg:text-4xl xl:text-5xl font-medium">
                                {{ addressesPageContent.name }}
                            </h3>
                            <h6 class="text-shadow text-md sm:text-xl lg:text-2xl xl:text-3xl font-medium">
                                {{ addressesPageContent.label }}
                            </h6>
                        </div>
                    </div>
                </div>
                <div id="text-content">

                    <p class="my-5 text-rebecca_purple text-center lg:text-start font-bold italic">
                        <a class="text-info hover:text-custom_blue cursor-pointer"
                           :href="route('home')"
                        >Lorem Airlines</a> >
                        <a class="text-info hover:text-custom_blue cursor-pointer"
                           :href="route('travel-guide')"
                        >Travel Guide</a> >
                        <a class="text-info hover:text-custom_blue cursor-pointer"
                           @click="backToDestination"
                        >{{ addressesPageContent.cityName }}</a>
                    </p>

                    <h5 class="text-xl lg:text-2xl text-center lg:text-start font-bold underline">{{ addressesPageContent.title }}</h5>

                    <article class="text-sm sm:text-md text-custom_blue p-5">
                        {{ addressesPageContent.description }}
                    </article>

                    <div class="contanct-datas text-custom_blue p-5 bg-lightskyblue border-l-8 border-custom_blue">
                        <div v-if="addressesPageContent.address" class="block md:flex md:items-center">
                            <p class="block font-bold underline">Address:</p>
                            <p class="text-sm md:text-md md:pl-2">{{ addressesPageContent.address }}</p>
                        </div>
                        <div v-if="addressesPageContent.tel" class="block md:flex md:items-center my-2">
                            <p class="block font-bold underline">Tel:</p>
                            <p class="text-sm md:text-md md:pl-2">{{ addressesPageContent.tel }}</p>
                        </div>
                        <div v-if="addressesPageContent.web" class="block md:flex md:items-center my-2">
                            <p class="block font-bold underline">Web:</p>
                            <p class="text-sm md:text-md md:pl-2">{{ addressesPageContent.web }}</p>
                        </div>
                        <div v-if="addressesPageContent.email" class="block md:flex md:items-center my-2">
                            <p class="block font-bold underline">E-mail:</p>
                            <p class="text-sm md:text-md md:pl-2">{{ addressesPageContent.email }}</p>
                        </div>
                    </div>
                    <p class="h-14 bg-custom_blue text-whitesmoke text-center pt-5">Lorem Airlines</p>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<style scoped>
#wrapper {
    display: block;
}

.navbar_ {
    position: -webkit-sticky; /* Safari */
    position: sticky;
    top: 0;
    z-index: 2;
}

.wrapper {
    height: auto;
    width: 100%;
}

#addresses-page {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

nav {
    width: 100%;
    height: 60px;
    background: whitesmoke;
    color: rgb(9, 55, 115);
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1;
}

nav p {
    padding-top: 15px;
}

.title {
    width: 100%;
    height: 100px;
    background: transparent;
    color: whitesmoke;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: 60px;
    left: 0;
}

h3,
h6 {
    margin: 0;
}

.title h6 {
    text-transform: uppercase;
    margin-top: 15px;
}

.content-container {
    width: 85%;
    height: 120vh;
}

.img {
    height: 100%;
    width: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    margin: 0 auto;
}

#text-content {
    width: 100%;
    height: 100%;
    margin: 0 auto;
}

article {
    text-align: justify;
}

.contanct-datas {
    margin-top: 50px;
}

.contanct-datas h6 {
    margin: 15px 0;
}

h5 {
    color: rgb(9, 55, 115);
    padding: 5px 0;
}

a:focus {
    border: none !important;
    box-shadow: none !important;
}

@media(max-width: 1024px){
    .content-container{
        width: 100%;
    }
}

</style>
