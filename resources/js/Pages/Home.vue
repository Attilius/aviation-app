<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '../Layouts/AppLayout.vue';
import HomeHeader from '../Components/HomeHeader.vue';
</script>

<template>
    <Head>
        <title>Home</title>
    </Head>

    <AppLayout title="Home">
        <div class="">
            <HomeHeader />
        </div>
    </AppLayout>
</template>
