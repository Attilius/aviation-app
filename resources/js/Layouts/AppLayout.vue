<script setup>
import { ref } from 'vue';
import {Head, Link, router, useForm} from '@inertiajs/vue3';
import ApplicationLogo from '../Components/ApplicationLogo.vue';
import Dropdown from '../Components/Dropdown.vue';
import DropdownLink from '../Components/DropdownLink.vue';
import NavLink from '../Components/NavLink.vue';
import ResponsiveNavLink from '../Components/ResponsiveNavLink.vue';
import InputAttributesBuilder from "../Utils/InputAttributesBuilder";
import JsonDataProvider from "../Utils/JsonDataProvider";
import PrimaryButton from '../Components/PrimaryButton.vue';
import { mainNavLinkAttributes, authNavLinkAttributes }  from '../Config/navigation.js';

defineProps({
    title: String,
    canLogin: Boolean,
    canRegister: Boolean
});

const form = useForm({
    email: ''
});

const showingNavigationDropdown = ref(false);

const actualYear = new Date().getFullYear();
const inputAttributes = new InputAttributesBuilder('subscribe').build();
const dataProvider = new JsonDataProvider('name').getData();


const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title" />
        <div class="max-h-screen">
            <nav class="bg-custom_blue fixed top-0 left-0 right-0 z-20">

                <!-- Primary Navigation Menu -->

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">

                        <!-- Logo -->

                        <div class="shrink-0 flex items-center">

                            <Link :href="route('home')">
                                <ApplicationLogo class="block h-12 w-auto" />
                            </Link>
                        </div>
                        <div class="flex">

                            <!-- Navigation Links -->

                            <div v-for="value in mainNavLinkAttributes"
                                 class="text-whitesmoke sm:-my-px sm:ml-0 sm:flex menu-item"
                            >
                                <NavLink :href="value.href" :active="value.active">
                                    {{ value.name }}
                                </NavLink>
                            </div>

                            <!-- Teams Dropdown -->
                            <div v-if="!canLogin" >
                                <Dropdown v-if="$page.props.jetstream.hasTeamFeatures" align="right" width="60">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent
                                                           text-sm leading-4 font-medium rounded-md text-gray-500
                                                           bg-white hover:bg-gray-50 hover:text-gray-700
                                                           focus:outline-none focus:bg-gray-50 active:bg-gray-50
                                                           transition">
                                                {{ $page.props.user.current_team.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <div class="w-60">
                                            <!-- Team Management -->
                                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    Manage Team
                                                </div>

                                                <!-- Team Settings -->
                                                <DropdownLink :href="route('teams.show', $page.props.user.current_team)">
                                                    Team Settings
                                                </DropdownLink>

                                                <DropdownLink v-if="$page.props.jetstream.canCreateTeams"
                                                              :href="route('teams.create')">
                                                    Create New Team
                                                </DropdownLink>

                                                <div class="border-t border-gray-100" />

                                                <!-- Team Switcher -->
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    Switch Teams
                                                </div>

                                                <template v-for="team in $page.props.user.all_teams" :key="team.id">
                                                    <form @submit.prevent="switchToTeam(team)">
                                                        <DropdownLink as="button">
                                                            <div class="flex items-center">
                                                                <svg v-if="team.id == $page.props.user.current_team_id"
                                                                     class="mr-2 h-5 w-5 text-green-400"
                                                                     xmlns="http://www.w3.org/2000/svg"
                                                                     fill="none" viewBox="0 0 24 24"
                                                                     stroke-width="1.5" stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                          stroke-linejoin="round"
                                                                          d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>

                                                                <div>{{ team.name }}</div>
                                                            </div>
                                                        </DropdownLink>
                                                    </form>
                                                </template>
                                            </template>
                                        </div>
                                    </template>
                                </Dropdown>


                                <!-- Settings Dropdown -->
                                <div class="relative">
                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                            <button v-if="$page.props.jetstream.managesProfilePhotos"
                                                    class="flex text-sm border-2 border-transparent rounded-full
                                                      focus:outline-none focus:border-gray-300 transition">
                                                <img class="h-8 w-8 rounded-full object-cover"
                                                     :src="$page.props.user.profile_photo_url"
                                                     :alt="$page.props.user.name">
                                            </button>

                                            <span v-else class="hidden sm:-my-px sm:ml-0 sm:flex h-66">
                                            <button type="button"
                                                    class="inline-flex items-center text-base font-semi-bold
                                                           text-whitesmoke focus:outline-none transition menu-item
                                                           hover:text-whitesmoke leading-5 py-auto h-full">

                                                <i class="material-icons prefix mr-1">account_circle</i>
                                                {{ $page.props.user.name }}

                                                <!-- <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                     <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                 </svg> -->
                                            </button>
                                        </span>
                                        </template>

                                        <template #content>
                                            <!-- Account Management -->
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                Manage Account
                                            </div>

                                            <DropdownLink :href="route('profile.show')">
                                                Profile
                                            </DropdownLink>

                                            <DropdownLink v-if="$page.props.jetstream.hasApiFeatures"
                                                          :href="route('api-tokens.index')">
                                                API Tokens
                                            </DropdownLink>

                                            <div class="border-t border-gray-100" />

                                            <!-- Authentication -->
                                            <form @submit.prevent="logout">
                                                <DropdownLink as="button">
                                                    Logout
                                                </DropdownLink>
                                            </form>
                                        </template>
                                    </Dropdown>
                                </div>
                            </div>
                            <div v-else class="flex">

                                <!--Auth navigation-->

                                <div v-for="value in authNavLinkAttributes"
                                     class="text-whitesmoke sm:-my-px sm:ml-0 sm:flex menu-item"
                                >
                                    <NavLink :href="value.href">
                                        {{ value.name }}
                                    </NavLink>
                                </div>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button class="inline-flex items-center justify-center p-2 rounded-md text-white
                                           hover:text-lightskyblue hover:bg-gray-100 focus:outline-none
                                           focus:bg-gray-100 focus:text-gray-500 transition"
                                    @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div v-for="value in mainNavLinkAttributes" class="pt-1 pb-1">
                        <ResponsiveNavLink :href="value.href" :active="value.active">
                            {{ value.name }}
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->

                    <div v-if="!canLogin" class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                                <img class="h-10 w-10 rounded-full object-cover"
                                     :src="$page.props.user.profile_photo_url"
                                     :alt="$page.props.user.name">
                            </div>

                            <div>
                                <div class="font-semi-bold text-base text-white">
                                    {{ $page.props.user.name }}
                                </div>
                                <div class="font-semi-bold text-sm text-white">
                                    {{ $page.props.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')"
                                               :active="route().current('profile.show')">
                                Profile
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures"
                                               :href="route('api-tokens.index')"
                                               :active="route().current('api-tokens.index')">
                                API Tokens
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    Log Out
                                </ResponsiveNavLink>
                            </form>

                            <!-- Team Management -->
                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                <div class="border-t border-gray-200" />

                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Manage Team
                                </div>

                                <!-- Team Settings -->
                                <ResponsiveNavLink :href="route('teams.show', $page.props.user.current_team)"
                                                   :active="route().current('teams.show')">
                                    Team Settings
                                </ResponsiveNavLink>

                                <ResponsiveNavLink v-if="$page.props.jetstream.canCreateTeams"
                                                   :href="route('teams.create')"
                                                   :active="route().current('teams.create')">
                                    Create New Team
                                </ResponsiveNavLink>

                                <div class="border-t border-gray-200" />

                                <!-- Team Switcher -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Switch Teams
                                </div>

                                <template v-for="team in $page.props.user.all_teams" :key="team.id">
                                    <form @submit.prevent="switchToTeam(team)">
                                        <ResponsiveNavLink as="button">
                                            <div class="flex items-center">
                                                <svg v-if="team.id == $page.props.user.current_team_id" class="mr-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <div>{{ team.name }}</div>
                                            </div>
                                        </ResponsiveNavLink>
                                    </form>
                                </template>
                            </template>
                        </div>
                    </div>
                    <div v-else>

                        <!--Responsive auth navigation-->

                        <div v-for="value in authNavLinkAttributes" class="pt-1 pb-1">
                            <ResponsiveNavLink :href="value.href">
                                {{ value.name }}
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main>
                <slot />
            </main>

            <!-- Page Footer -->
            <footer class="text-center lg:text-left bg-custom_blue">
                <div class="flex justify-center items-center p-6">
                    <div class="mr-12 hidden lg:block text-info">
                        <span>Follow us on social networks:</span>
                    </div>
                    <div class="flex justify-center text-info">
                        <a href="#!" class="mr-6 hover:text-whitesmoke">
                            <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-f"
                                 class="w-2.5" role="img" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 320 512">
                                <path fill="currentColor"
                                      d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z">
                                </path>
                            </svg>
                        </a>
                        <a href="#!" class="mr-6 hover:text-whitesmoke">
                            <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="twitter"
                                 class="w-4" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor"
                                      d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z">
                                </path>
                            </svg>
                        </a>
                        <a href="#!" class="mr-6 hover:text-whitesmoke">
                            <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="google"
                                 class="w-3.5" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512">
                                <path fill="currentColor"
                                      d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z">
                                </path>
                            </svg>
                        </a>
                        <a href="#!" class="mr-6 hover:text-whitesmoke">
                            <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="instagram"
                                 class="w-3.5" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path fill="currentColor"
                                      d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z">
                                </path>
                            </svg>
                        </a>
                        <a href="#!" class="mr-6 hover:text-whitesmoke">
                            <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="linkedin-in"
                                 class="w-3.5" role="img" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 448 512">
                                <path fill="currentColor"
                                      d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="mx-6 text-center md:text-left">
                    <div class="grid grid-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

                        <div class="">
                            <h6 class="uppercase font-semi-bold flex justify-center md:justify-start text-whitesmoke">
                                Locations
                            </h6>
                            <p v-for="value in mainNavLinkAttributes" class="mb-1">
                                <a :href="value.href"
                                   class="text-info hover:text-whitesmoke text-xs font-light">
                                    {{ value.name }}
                                </a>
                            </p>
                        </div>

                        <!--Partners column-->

                        <div class="">
                            <h6 class="uppercase font-semi-boldflex justify-center md:justify-start text-whitesmoke">
                                Our partners
                            </h6>
                            <div v-for="item in dataProvider">
                                <p class="text-xs font-light text-info">{{ item }}</p>
                            </div>
                        </div>

                        <!--Contact column-->

                        <div class="">
                            <h6 class="uppercase font-semi-bold flex justify-center md:justify-start text-whitesmoke">
                                Contact
                            </h6>
                            <p class="flex items-center justify-center md:justify-start mb-4 text-xs font-light text-info">
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="home"
                                     class="w-4 mr-4" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                    <path fill="currentColor"
                                          d="M280.37 148.26L96 300.11V464a16 16 0 0 0 16 16l112.06-.29a16 16 0 0 0 15.92-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.64a16 16 0 0 0 16 16.05L464 480a16 16 0 0 0 16-16V300L295.67 148.26a12.19 12.19 0 0 0-15.3 0zM571.6 251.47L488 182.56V44.05a12 12 0 0 0-12-12h-56a12 12 0 0 0-12 12v72.61L318.47 43a48 48 0 0 0-61 0L4.34 251.47a12 12 0 0 0-1.6 16.9l25.5 31A12 12 0 0 0 45.15 301l235.22-193.74a12.19 12.19 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0-1.7-16.93z">
                                    </path>
                                </svg>
                                New York, NY 10012, US
                            </p>
                            <p class="flex items-center justify-center md:justify-start mb-4 text-xs font-light text-info">
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope"
                                     class="w-4 mr-4" role="img" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 512 512">
                                    <path fill="currentColor"
                                          d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z">
                                    </path>
                                </svg>
                                info@example.com
                            </p>
                            <p class="flex items-center justify-center md:justify-start mb-4 text-xs font-light text-info">
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone"
                                     class="w-4 mr-4" role="img" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 512 512">
                                    <path fill="currentColor"
                                          d="M493.4 24.6l-104-24c-11.3-2.6-22.9 3.3-27.5 13.9l-48 112c-4.2 9.8-1.4 21.3 6.9 28l60.6 49.6c-36 76.7-98.9 140.5-177.2 177.2l-49.6-60.6c-6.8-8.3-18.2-11.1-28-6.9l-112 48C3.9 366.5-2 378.1.6 389.4l24 104C27.1 504.2 36.7 512 48 512c256.1 0 464-207.5 464-464 0-11.2-7.7-20.9-18.6-23.4z">
                                    </path>
                                </svg>
                                + 01 234 567 88
                            </p>
                            <p class="flex items-center justify-center md:justify-start text-xs font-light text-info">
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="print"
                                     class="w-4 mr-4" role="img" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 512 512">
                                    <path fill="currentColor"
                                          d="M448 192V77.25c0-8.49-3.37-16.62-9.37-22.63L393.37 9.37c-6-6-14.14-9.37-22.63-9.37H96C78.33 0 64 14.33 64 32v160c-35.35 0-64 28.65-64 64v112c0 8.84 7.16 16 16 16h48v96c0 17.67 14.33 32 32 32h320c17.67 0 32-14.33 32-32v-96h48c8.84 0 16-7.16 16-16V256c0-35.35-28.65-64-64-64zm-64 256H128v-96h256v96zm0-224H128V64h192v48c0 8.84 7.16 16 16 16h48v96zm48 72c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z">
                                    </path>
                                </svg>
                                + 01 234 567 89
                            </p>
                        </div>

                        <!--Booking and Payment options column-->

                        <div class="">
                            <h6 class="uppercase font-semi-bold flex justify-center md:justify-start text-whitesmoke">
                                Would you like to booking?
                            </h6>
                            <p class="text-xs font-light text-info">
                                You can book your flight with us in just a few clicks, and we
                                also offer a range of services.
                            </p>
                            <PrimaryButton class="mt-4">

                                <!--TODO fixing routing with or without authentication!!!-->

                                <a v-if="canLogin" :href="route('home')">Booking now</a>
                                <a v-else :href="'/'">Booking now</a>
                            </PrimaryButton>
                            <p class="mt-3 text-whitesmoke">Payment options</p>
                            <img class="mt-4 w-40 mx-auto md:mx-0" src="/img/payment/pay.png" alt="payment cards">
                        </div>

                    </div>
                </div>
                <div class="text-center p-6 text-sm font-light text-info">
                    <span>© {{ actualYear }} Created by:</span>
                    <p class="inline pl-1">Attilius</p>
                </div>
            </footer>
        </div>
    </div>
</template>
