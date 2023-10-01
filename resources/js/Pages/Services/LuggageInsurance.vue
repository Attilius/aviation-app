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
    tableHeadFields: Array,
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
                <div class="container lg:w-4/5.2 lg:h-[calc(100vh+450px)] xl:h-[calc(100vh+500px)] 2xl:h-[calc(100vh+400px)] flex-col
                            justify-center align-middle px-5 mx-auto"
                >
                    <AnimatedHeader :headerImageTitles="headerImageTitles" :styles="styles" />
                    <h2 class="w-full text-whitesmoke text-2xl sm:text-3xl lg:text-4xl 2xl:text-5xl pt-10 px-5 pb-2
                               mt-10 lg:relative lg:top-125 capitalize text-center lg:text-start text-shadow
                               after:content-[''] after:absolute after:w-1/10 after:bg-lightskyblue after:h-0.5
                               lg:after:h-1 2xl:after:h-2 after:top-28 md:after:top-30 lg:after:top-22 2xl:after:top-26
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

                    <!-- Table -->

                    <table class="sm:w-full lg:w-1/11 table-auto lg:relative lg:top-125 lg:left-5 rounded-sm shadow-3xl xxs">
                        <thead>
                        <tr>
                            <th class="capitalize text-left text-whitesmoke bg-custom_blue py-1 lg:py-3 pl-2
                                       text-xs md:text-sm lg:text-base xxs"
                                v-for="field in tableHeadFields"
                                :key="field.name"
                            >
                                {{ field.name }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="category in categories"
                            :key="category.size"
                            :style="{ backgroundColor: category.id % 2 === 0 ? 'lightskyblue' : '#8bc5e8' }"
                        >
                            <td class="capitalize text-left text-custom_blue text-xs md:text-sm lg:text-base
                                       py-2 lg:py-4 pl-2 border-t xxs"
                            >
                                {{ category.size }}
                            </td>
                            <td class="capitalize text-left text-custom_blue text-xs md:text-sm lg:text-base
                                       py-2 lg:py-4 pl-2 border-t xxs"
                            >
                                {{ category.height }}
                            </td>
                            <td class="capitalize text-left text-custom_blue text-xs md:text-sm lg:text-base
                                       py-2 lg:py-4 pl-2 border-t xxs"
                            >
                                {{ category.width }}
                            </td>
                            <td class="capitalize text-left text-custom_blue text-xs md:text-sm lg:text-base
                                       py-2 lg:py-4 pl-2 border-t xxs"
                            >
                                {{ category.depth }}
                            </td>
                            <td class="capitalize text-left text-custom_blue text-xs md:text-sm lg:text-base
                                       py-2 lg:py-4 pl-2 border-t xxs"
                            >
                                {{ category.capacity }}
                            </td>
                            <td class="capitalize text-left text-custom_blue text-xs md:text-sm lg:text-base
                                       py-2 lg:py-4 pl-2 border-t xxs"
                            >
                                {{ category.weight }}
                            </td>
                            <td class="capitalize text-left bg-custom_blue text-whitesmoke text-xs md:text-sm
                                       lg:text-base py-4 sm:pl-2 border-t text-center xxs"
                            >
                                {{ category.price }}
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </AppLayout>

</template>

<style scoped>
.xxs {}
@media (max-width: 383px){
    .xxs {
        font-size: 7px;
        line-height: 11px;
    }
}

</style>
