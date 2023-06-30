<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import ApplicationLogo from '../Components/ApplicationLogo.vue';
import NavLink from '../Components/NavLink.vue';
import InputError from '../Components/InputError.vue';
import MaterialUiInput from '../Components/MaterialUiInput.vue';
import InputAttributesBuilder from '../Utils/InputAttributesBuilder.js';
import PrimaryButton from '../Components/PrimaryButton.vue';

defineProps({
    title: String,
    greeting: String,
    binderWord: String,
    companyName: String,
    authNavLinkAttributes: Array,
    subscriberMessage: String,
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
        <title>{{ title }}</title>
    </Head>

    <div class="max-h-screen hw-100 flex items-center bg-welcome bg-cover bg-center">
        <div class="w-full h-screen flex-col justify-center items-center bg-shadow-skin">
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
            <div class="flex-col justify-center items-center relative top-1/3">
                <h2 class="text-whitesmoke text-3xl lg:text-6xl xl:text-9xl text-center"
                >
                    {{ greeting }}
                </h2>
                <h3 class="text-whitesmoke text-lg sm:text-3xl lg:text-6xl text-center mb-5 md:mb-16"
                >
                    <span class="text-lightskyblue font-medium text-sm md:text-5xl">{{ binderWord }}</span>
                    {{ companyName }}
                </h3>

                <!-- Newsletter -->

                <p class="text-whitesmoke nano-text sm:text-xs lg:text-sm text-center mb-2">
                    {{ subscriberMessage }}
                </p>

                <form @submit.prevent="submit">
                    <div class="w-4/5.2 sm:w-full flex-col max-w-md px-6 py-4 shadow-md overflow-hidden rounded-lg
                        auth-card-bg mx-auto">

                        <div v-if="status" class="mb-4 font-medium text-xs sm:text-sm text-success text-center"
                        >
                            {{ status }}
                        </div>

                        <div class="xs:flex-col sm:flex">
                            <MaterialUiInput
                                :id="inputAttributes.email.id"
                                v-model="form.email"
                                :type="inputAttributes.email.type"
                                class="mt-1 block w-full"
                                :customClasses="inputAttributes.email.customClasses"
                                :label="inputAttributes.email.label"
                                :status="status"
                            />

                            <div class="flex justify-center">
                                <PrimaryButton class="mt-5 sm:ml-4 sm:mt-0"
                                               :class="{ 'opacity-25': form.processing }"
                                               :disabled="form.processing"
                                >
                                    Subscribe
                                </PrimaryButton>
                            </div>

                        </div>

                        <InputError class="mt-2" :message="form.errors.email" />

                    </div>
                </form>

            </div>

        </div>
    </div>

</template>


