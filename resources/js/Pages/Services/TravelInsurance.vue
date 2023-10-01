<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import AnimatedHeader from '../../Components/AnimatedHeader.vue';
import SectionBorder from '../../Components/SectionBorder.vue';

defineProps({
    title: String,
    headerImageTitles: Object,
    styles: Array,
    description: String,
    categories: Array
});
</script>

<template>

    <Head :title="title">
        <title></title>
    </Head>

    <AppLayout :title="title">
        <div class="w-full bg-services bg-cover bg-no-repeat">
            <div class="w-full bg-custom-blue-alfa-8 flex-col justify-around">
                <div class="container lg:w-4/5.2 lg:h-[calc(100vh+2200px)] xl:h-[calc(100vh+2000px)] flex-col
                            justify-center align-middle px-5 mx-auto"
                >
                    <AnimatedHeader :headerImageTitles="headerImageTitles" :styles="styles" />
                    <h2 class="w-full text-whitesmoke text-2xl sm:text-3xl lg:text-4xl 2xl:text-5xl pt-10 px-5 pb-2
                               mt-10 lg:relative lg:top-125 capitalize text-center lg:text-start text-shadow
                               after:content-[''] after:absolute after:w-1/10 after:bg-lightskyblue after:h-0.5
                               lg:after:h-1 2xl:after:h-2 after:top-28 md:after:top-29.5 lg:after:top-20
                               2xl:after:top-24
                               after:left-1/15 lg:after:left-5 after:mb-5 after:rounded-full after:shadow-3xl"
                    >
                        {{ title }}
                    </h2>
                    <article class="w-full lg:w-1/11 text-textGray text-xs lg:text-base lg:relative lg:top-125
                                    2xl:top-133 px-0 py-6 lg:ml-5"
                    >
                        {{ description }}

                        <SectionBorder />

                    </article>

                    <section :id="category.id"
                             class="w-1/11 text-textGray px-0 py-6 lg:relative top-130 left-5"
                             v-for="category in categories"
                             :key="category.name"
                    >
                        <div class="flex items-center">
                            <h3 class="lg:relative bg-white-alfa-6 text-lg lg:text-xl xl:text-2xl text-whitesmoke
                                       capitalize p-1 pl-2 lg:p-2 xl:p-3 2xl:p-4 my-5 w-1/15 lg:w-2/5 xl:w-1/5
                                       rounded-full border-4 border-whitesmoke text-shadow z-10">
                                {{ category.name }}
                            </h3>
                            <img class="w-16 h-16 lg:w-20 lg:h-20 xl:w-24 xl:h-24 2xl:w-32 2xl:h-32 rounded-full
                                        relative right-10 lg:right-20 border-4 border-whitesmoke z-10"
                                 :src="category.src"
                                 :alt="category.alt"
                            >
                        </div>

                        <article class="border-4 border-whitesmoke rounded-lg p-7 relative text-sm lg:text-base
                                        -top-6 2xl:-top-8 left-8 mr-8"
                        >
                            {{ category.description }}
                        </article>

                    </section>

                </div>
            </div>
        </div>
    </AppLayout>

</template>
