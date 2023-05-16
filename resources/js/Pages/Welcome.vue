<script setup>
import { Head } from '@inertiajs/vue3';
import ApplicationLogo from '../Components/ApplicationLogo.vue';
import NavLink from '../Components/NavLink.vue';
import { authNavLinkAttributes }  from '../Config/navigation.js';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head>
        <title>Welcome</title>
    </Head>
    <div class="max-h-screen hw-100 flex items-center bg-welcome bg-cover bg-center">
        <div class="skin">
            <div class="max-h-screen">
                <nav class="bg-transparent fixed top-0 left-0 right-0 z-20">

                    <!-- Primary Navigation Menu -->

                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between h-16">

                            <!-- Logo -->

                            <div class="shrink-0 flex items-center">
                                <ApplicationLogo class="block h-12 w-auto" />
                            </div>

                            <div class="flex">

                                <!-- Navigation Links -->

                                <div v-for="value in authNavLinkAttributes"
                                     class="text-whitesmoke sm:-my-px sm:ml-0 sm:flex menu-item"
                                >
                                    <NavLink :href="value.href" :active="value.active">
                                        {{ value.name }}
                                    </NavLink>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <div>
                <h2 class="text-whitesmoke lg:text-9xl md:text-6xl sm:text-3xl">~Welcome~</h2>
                <h3 class="text-whitesmoke lg:text-6xl md:text-3xl sm:text-xl mb-40 text-center">
                    <span class="text-custom_blue font-medium">to</span>
                    Lorem Airlines
                </h3>
            </div>

                <!-- Newsletter -->

            <p class="text-whitesmoke lg:text-xl md:text-md sm:text-sm">
                Subscribe to our newsletter to receive our latest offers
            </p>
        </div>
    </div>

</template>
