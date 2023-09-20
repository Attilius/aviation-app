<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '../Layouts/AppLayout.vue';
import InputError from '../Components/InputError.vue';
import MaterialUiInput from '../Components/MaterialUiInput.vue';
import MaterialUiTextarea from '../Components/MaterialUiTextarea.vue';
import PrimaryButton from '../Components/PrimaryButton.vue';
import InputAttributesBuilder from '../Utils/InputAttributesBuilder.js';

const props = defineProps({
    status: String,
    title: String,
    pageTitle: String,
    contactData: Array
});

const inputAttributes = new InputAttributesBuilder('contact').build();

const form = useForm({
    name: '',
    email: '',
    subject: '',
    message: ''
});

const submit = () => {
    form.post(route('contactMessage.store'), {
        onFinish: () => form.reset()
    });
};
</script>

<template>

    <Head :title="title">
        <title></title>
    </Head>

    <AppLayout :title="title">

        <!-- Contact page content-->

        <div class="w-full flex-col justify-center items-center bg-center bg-cover bg-contact"
        >
            <div class="w-full flex-col justify-start"
                 :style="{background: 'rgba(7, 5, 5, 0.7)'}"
            >
                <h1 class="w-full relative mt-14 capitalize text-center text-whitesmoke pt-4 pr-6 pb-3 sm:pb-5 lg:pb-6
                           pl-9 text-2xl sm:text-3xl lg:text-4xl 2xl:text-5xl after:content-[''] after:absolute
                           after:bg-info after:w-1/33 after:h-0.5 sm:after:h-1 lg:after:h-2 after:-bottom-2.5
                           after:left-1/19 after:mb-5 after:rounded-full after:shadow-3xl text-shadow"
                >
                    {{ pageTitle }}
                </h1>
                <div class="w-1/2 h-80 sm:h-40 xl:h-20 grid gap-2 grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 my-10
                            ml-auto mr-auto"
                >
                    <div v-for="data in contactData" class="w-auto h-20 flex-center">
                        <font-awesome-icon
                            class="icon text-info text-sm sm:text-lg lg:text-xl 2xl:text-2xl bg-transparent border-none"
                            :icon=data.icon
                        />
                        <div class="w-full h-full flex-col justify-center">
                            <p class="text-whitesmoke text-center text-xs lg:text-sm my-1.5
                                      ml-auto mr-auto"
                            >
                                {{ data.text }}
                            </p>
                        </div>
                    </div>
                </div>

                <form @submit.prevent="submit">
                    <div class="flex-col md:w-1/2 h-1/3 mx-4 md:mx-auto px-6 py-4 shadow-md overflow-hidden
                                rounded-lg auth-card-bg relative bottom-5"
                    >
                        <div v-if="status" class="mb-4 font-medium text-sm text-success text-center">
                            {{ status }}
                        </div>

                        <div class="lg:flex">
                            <div class="lg:w-1/2 flex-col mx-5">
                                <div class="mt-6 w-full border-b-2 pb-0.25">
                                    <MaterialUiInput
                                        :id="inputAttributes.name.id"
                                        v-model="form.name"
                                        :type="inputAttributes.name.type"
                                        class="mt-1 block w-full"
                                        :customClasses="inputAttributes.name.customClasses"
                                        :label="inputAttributes.name.label"
                                    />

                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>
                                <div class="mt-6 w-full border-b-2 pb-0.25">
                                    <MaterialUiInput
                                        :id="inputAttributes.email.id"
                                        v-model="form.email"
                                        :type="inputAttributes.email.type"
                                        class="mt-1 block w-full"
                                        :customClasses="inputAttributes.email.customClasses"
                                        :label="inputAttributes.email.label"
                                    />

                                    <InputError class="mt-2" :message="form.errors.email" />
                                </div>
                                <div class="mt-6 w-full border-b-2 pb-0.25">
                                    <MaterialUiInput
                                        :id="inputAttributes.subject.id"
                                        v-model="form.subject"
                                        :type="inputAttributes.subject.type"
                                        class="mt-1 block w-full"
                                        :customClasses="inputAttributes.subject.customClasses"
                                        :label="inputAttributes.subject.label"
                                    />

                                    <InputError class="mt-2" :message="form.errors.subject" />
                                </div>
                            </div>

                            <!-- Message area -->

                            <div class="lg:w-1/2 flex-col mx-5">
                                <div class="mt-6">
                                    <MaterialUiTextarea
                                        :id="inputAttributes.message.id"
                                        :rows="inputAttributes.message.rows"
                                        :cols="inputAttributes.message.cols"
                                        :maxlength="inputAttributes.message.maxlength"
                                        v-model="form.message"
                                        :name="inputAttributes.message.name"
                                        class="mt-1 block w-full"
                                        :customClasses="inputAttributes.message.customClasses"
                                        :label="inputAttributes.message.label"
                                    />

                                    <InputError class="mt-2" :message="form.errors.message" />
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->

                        <div class="flex justify-center">
                            <PrimaryButton class="mt-5 mx-30"
                                           :class="{ 'opacity-25': form.processing }"
                                           :disabled="form.processing"
                            >
                                Submit
                            </PrimaryButton>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
