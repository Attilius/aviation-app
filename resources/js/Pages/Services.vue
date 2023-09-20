<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '../Layouts/AppLayout.vue';
import PrimaryButton from "../Components/PrimaryButton.vue";

const props = defineProps({
    title: String,
    headerImage: Object,
    cards: Array,
    banner: Object
});
</script>

<template>

    <Head :title="title">
        <title></title>
    </Head>

    <AppLayout :title="title">

        <div class="bg-services bg-no-repeat bg-cover">
            <div class="w-full mx-0 md:mx-auto bg-custom-blue-alfa-8">
                <div class="w-full px-0 md:px-1/8 mx-0 md:mx-auto mt-16">
                    <img class="w-full mx-auto"
                        :src="headerImage.src"
                        :alt="headerImage.alt"
                    >
                    <div class="w-full bg-whitesmoke grid gap-5 lg:grid-cols-2 2xl:grid-cols-3 p-5">
                        <div class="w-full h-80 place-self-center flex-col justify-start p-0 service"
                             v-for="card in cards"
                             :key="card.title"
                        >
                            <div class="w-full h-1/13 relative inline-block p-0">
                                <img
                                    class="w-full h-full block"
                                    :src="card.src"
                                    :alt="card.alt"
                                >
                                <div class="overlay bg-custom-blue-alfa-8">
                                    <div class="services-title">
                                        <div class="icon-box">
                                            <font-awesome-icon
                                                class="text-4xl bg-transparent text-lightskyblue border-none"
                                                :icon="card.icon"
                                            />
                                        </div>
                                        <h4 class="title">{{ card.title }}</h4>
                                    </div>
                                    <div class="hover-content">
                                        <p>{{ card.description }}</p>
                                        <Link class="service-read-more mt-3"
                                              :href="route(card.path)">read more ></Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="individual">
                        <h4 class="text-xl text-center">{{ banner.text }}</h4>
                        <PrimaryButton class="py-3 mx-30"
                                       type="button"
                        >
                            <a :href="route(banner.path)">Get a quote</a>
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.service-read-more {
    display: none;
}

.overlay {
    position: absolute;
    transition: all 0.3s ease-out;
    opacity: 1;
    width: 100%;
    height: 0;
    bottom: 0;
    left: 0;
    display: flex;
    flex-direction: column;
}

.hover-content {
    width: 100%;
    height: 100%;
    position: absolute;
    bottom: -50px;
    left: 95px;
    display: none;
}

p {
    font-size: 16px;
    color: whitesmoke;
    text-align: left;
    width: 60%;
    display: none;
    padding-top: 10px;
    font-weight: 300;
}

.services-title {
    position: absolute;
    width: 100%;
    display: flex;
    justify-content: flex-start;
    background: rgba(9, 55, 115, .9);
}

/* Services item hover settings */

.service:hover .overlay {
    height: 100%;
    opacity: 1;
}

.service:hover .services-title {
    background: transparent;
}

.service:hover p {
    display: inline;
    cursor: default;
}

.service:hover .service-read-more {
    color: whitesmoke;
    transition: all 0.4s ease 0.2s;
    display: block;
    cursor: default;
    font-weight: 600;
}

.service:hover .service-read-more:focus {
    border: none !important;
    box-shadow: none !important;
}

.service:hover .hover-content {
    display: flex;
    flex-direction: column;
}

.service:hover .service-read-more:hover {
    text-decoration: none;
    color: lightskyblue;
    cursor: pointer;
    -webkit-transition: 0.4s ease-in-out 0s;
    -moz-transition: 0.4s ease-in-out 0s;
    -o-transition: 0.4s ease-in-out 0s;
    transition: 0.4s ease-in-out 0s;
}

.icon-box {
    width: 66px;
    height: 66px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-right: 28px;
}

.title {
    margin-top: 5px;
    padding: 15px 0;
    position: relative;
    color: white;
    font-weight: 500;
    text-transform: capitalize;
    transition: 0.3s all ease;
    z-index: 1;
    text-align: center;
    display: block;
    font-size: 1.2rem;
}

.individual {
    width: 100%;
    height: 80px;
    background: lightskyblue;
    display: flex;
    justify-content: space-around;
    align-items: center;
}

.individual h4 {
    color: white;
    padding-top: 5px;
}

/* Responsive settings */

@media (max-width: 1280px) {
    .service {
        height: 300px;
    }
}

@media (max-width: 1024px) {
    .service {
        width: 100%;
    }

    .overlay {
        height: 100%;
        opacity: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .hover-content {
        display: flex;
        flex-direction: column;
        left: 0;
        bottom: -100px;
    }

    .icon-box {
        margin: 0;
    }

    .services-title {
        background: transparent;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        top: 0;
    }

    .title {
        margin: 0;
        padding: 0;
    }

    p {
        display: inline;
        cursor: default;
        text-align: center;
        width: 60%;
        margin: 0 auto;
        padding: 0;
        font-size: 0.8rem;
    }

    .service-read-more {
        color: lightskyblue !important;
        display: block;
        cursor: default;
        font-weight: 600;
        text-align: center;
        padding-top: 10px;
        font-size: 0.9rem;
    }

    .individual {
        flex-direction: column;
        height: 120px;
    }

    .individual h4 {
        font-size: 1.2rem;
    }

    .individual a {
        margin-bottom: 20px;
    }
}

@media (max-width: 640px) {
    .title {
        font-size: 1rem;
    }

    p, .service-read-more {
        font-size: 12px;
    }
}
</style>
