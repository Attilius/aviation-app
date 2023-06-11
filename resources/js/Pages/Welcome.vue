<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import ApplicationLogo from '../Components/ApplicationLogo.vue';
import NavLink from '../Components/NavLink.vue';
import { authNavLinkAttributes }  from '../Config/navigation.js';
import InputError from '../Components/InputError.vue';
import MaterialUiInput from '../Components/MaterialUiInput.vue';
import InputAttributesBuilder from '../Utils/InputAttributesBuilder.js';
import PrimaryButton from '../Components/PrimaryButton.vue';

defineProps({
    status: String,
});

const form = useForm({
    email: ''
});

const inputAttributes = new InputAttributesBuilder('subscribe').build();

const submit = () => {
    form.post(route('register.subscriber'));
    form.reset();
};

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
                    <span class="text-lightskyblue font-medium">to</span>
                    Lorem Airlines
                </h3>
            </div>

                <!-- Newsletter -->

            <p class="text-whitesmoke lg:text-sm xs:text-xs">
                Subscribe to our newsletter to receive our latest offers
            </p>

            <form @submit.prevent="submit">
                <div  class="flex flex-col w-full sm:max-w-md px-6 py-4 shadow-md overflow-hidden sm:rounded-lg
                        auth-card-bg">

                    <div v-if="status" class="mb-4 font-medium text-sm text-success text-center">
                        {{ status }}
                    </div>

                    <div class="flex">
                        <MaterialUiInput
                            :id="inputAttributes.email.id"
                            v-model="form.email"
                            :type="inputAttributes.email.type"
                            class="mt-1 block w-full"
                            :customClasses="inputAttributes.email.customClasses"
                            :label="inputAttributes.email.label"
                            :status="status"
                        />

                        <PrimaryButton class="ml-4"
                                       :class="{ 'opacity-25': form.processing }"
                                       :disabled="form.processing"
                        >
                            Subscribe
                        </PrimaryButton>
                    </div>

                    <InputError class="mt-2" :message="form.errors.email" />

                </div>
            </form>

        </div>
    </div>

</template>
