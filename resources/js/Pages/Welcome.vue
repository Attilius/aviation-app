<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '../Layouts/AppLayout.vue';
import Welcome from '../Components/Welcome.vue';
//import HomeContent from './Content/HomeContent.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head>
        <title>Home</title>
    </Head>

    <AppLayout :canLogin="canLogin" :canRegister="canRegister" title="Home">
        <div class="">
            <Welcome />
           <!-- <HomeContent /> -->
        </div>
    </AppLayout>
</template>
