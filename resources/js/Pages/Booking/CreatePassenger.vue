<script setup>
import { computed, onMounted, onBeforeMount, ref, reactive, watch } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { countryCodes } from "../../Config/selectOption.js";
import AppLayout from '../../Layouts/AppLayout.vue';
import ProgressBar from '../../Components/ProgressBar.vue'
import InputError from '../../Components/InputError.vue';
import MaterialUiInput from '../../Components/MaterialUiInput.vue';
import MaterialUiSelect from '../../Components/MaterialUiSelect.vue';
import PrimaryButton from '../../Components/PrimaryButton.vue';
import Caret from '../../Components/Caret.vue';
import InputAttributesBuilder from "../../Utils/InputAttributesBuilder";

const props = defineProps({
    progressId: String,
    title: String,
    cost: String,
    targetOfPlaneChoosing: String,
    passengers: Array
});

const formState = ref('before submit');

const formStateModifyer = computed({
    set(val) {
        formState.value = val;
    }
});

const html = reactive({
    singleElements: [
        {
            id: 'submit-button-box',
            classes: {
                base: 'flex',
                new: 'hidden'
            }
        },
        {
            id: 'contact-box',
            classes: {
                base: 'hidden',
                new: 'block'
            }
        },
        {
            id: 'caret',
            classes: {
                base: 'hidden',
                new: 'inline'
            }
        }
    ],
    multipleElements: [
        {
            classIdentifyer: '.input-box',
            classes: {
                base: 'flex',
                new: 'hidden'
            }
        },
        {
            classIdentifyer: '.check-icon',
            classes: {
                base: 'hidden',
                new: 'inline'
            }
        },
        {
            classIdentifyer: '.passenger-id',
            classes: {
                base: 'py-5',
                new: 'py-1'
            }
        },
        {
            classIdentifyer: '.passenger-id',
            classes: {
                base: 'mb-5',
                new: 'mb-1'
            }
        }
    ]
});
const inputLabel = reactive({
    email_label: {
        _for_: 'email',
        textValue: 'Email*',
        customClasses: ['text-custom_blue', 'peer-focus:text-lightskyblue']
    }
});

const form = useForm({
    passengers: [],
    country_code: '',
    phone_number: '',
    email_address: '',
    cost: parseInt(props.cost)
});

const passengerInputAttributes = new InputAttributesBuilder('setPassenger').build();
const contactPersonInputAttributes = new InputAttributesBuilder('setContactPerson').build();

onBeforeMount(() => {
    for(let i = 0; i < props.passengers.length; i++){
        form.passengers.push({
            first_name: '',
            last_name: ''
        });
    }
});

onMounted(() => {
    const passengersHeadling = document.getElementById('passengers-headling');

    eventListener(passengersHeadling, 'click', changeFormState);
});

watch(formState,(newState) => {
    const passengersHeadling = document.getElementById('passengers-headling');
    const passengerType = document.querySelectorAll('.passenger-type');
    const passengerBox = document.querySelectorAll('.passenger-box');

    if(newState) {
        classListHandler(passengersHeadling, 'cursor-pointer');
        classListHandler(passengerBox, 'h-auto', 'multiple');
        classAttributeChanger(html.singleElements, 'single');
        classAttributeChanger(html.multipleElements, 'multiple');

        (newState === 'after submit')
            ? setPassengersFullName(passengerType)
            : resetPassengersFullName(passengerType);
    }
});

const classAttributeChanger = (htmlElements, objectType) => {
    htmlElements.forEach((item) => {
        const classItem = item.classes;
        const htmlItem = (objectType === 'single')
            ? document.getElementById(item.id)
            : document.querySelectorAll(item.classIdentifyer);

        if(objectType === 'single') {
            htmlItem.classList.contains(classItem.base)
                ? htmlItem.classList.replace(classItem.base, classItem.new)
                : htmlItem.classList.replace(classItem.new, classItem.base);
        } else {
            for (const item of htmlItem) {
                item.classList.contains(classItem.base)
                    ? item.classList.replace(classItem.base, classItem.new)
                    : item.classList.replace(classItem.new, classItem.base);
            }
        }
    });
}

const changeFormState = (state = 'before submit') => {
    formStateModifyer.value = state;
}

const eventListener = (item, event, action) => {
    item.addEventListener(event, action);
}

const classListHandler = (item, className, itemType = 'single') => {
    if(itemType === 'single') {
        item.classList.contains(className)
            ? item.classList.remove(className)
            : item.classList.add(className);
    } else {
        item.forEach((element) => {
            element.classList.contains(className)
                ? element.classList.remove(className)
                : element.classList.add(className);
        });
    }
}

const setPassengersFullName = (item) => {
    item.forEach((item, index) => {
        item.textContent = form.passengers[index].first_name +' '+ form.passengers[index].last_name;
    });
}

const resetPassengersFullName = (item) => {
    item.forEach((item, index) => {
        item.textContent = props.passengers[index].type;
    });
}

const submitPassengers = () => {
    changeFormState('after submit');
    form.post(route('store-passenger'));
}

const submitContact = () => {
    form.post(route('store-reservation-contact'));
}
</script>

<template>
    <Head :title="title">
        <title></title>
    </Head>

    <AppLayout :title="title">
        <div class="w-full bg-booking bg-cover bg-no-repeat">
            <div class="w-full bg-custom-blue-alfa-8">

                <ProgressBar class="bg-whitesmoke relative top-16"
                             :progressId="progressId"
                             :cost="form.cost"
                             :targetOfPlaneChoosing="targetOfPlaneChoosing"
                />

                <div class="w-full lg:w-9/12 mt-30 bg-whitesmoke mx-auto lg:rounded-lg shadow-3xl">

                    <h1 id="passengers-headling"
                        class="w-full h-20 text-whitesmoke bg-custom_blue relative pl-6 text-lg lg:text-2xl
                               font-semibold pt-6 lg:rounded-t-lg"
                    >
                        <font-awesome-icon class="pr-5" :icon="['fas', 'users']" />
                        Passengers
                        <Caret id="caret" _class="hidden float-right pr-5 pt-1"/>
                    </h1>

                    <form @submit.prevent="submitPassengers">
                        <div v-for="passenger in passengers" :key="passenger.id" class="passenger-box">
                            <h2 class="text-base lg:text-lg font-semibold text-custom_blue mb-5 px-10 py-5 passenger-id"
                            >
                                Passenger {{ passenger.id }}:
                                <span class="text-base font-light passenger-type">
                                    {{ passenger.type }}
                                </span>
                                <font-awesome-icon class="hidden ml-2 rounded-full bg-success text-whitesmoke check-icon
                                                          p-1 relative top-0.5"
                                                   :icon="['fas', 'check']" />
                            </h2>
                            <div class="flex justify-between px-10 py-1 mobile input-box">
                                <div class="w-full lg:w-1/19 border-b-2 pb-0.25">
                                    <MaterialUiInput
                                        :id="passengerInputAttributes.first_name.id + passenger.id"
                                        v-model="form.passengers[passenger.id-1].first_name"
                                        :type="passengerInputAttributes.first_name.type"
                                        class="mt-1 block"
                                        :customClasses="passengerInputAttributes.first_name.customClasses"
                                        :label="passengerInputAttributes.first_name.label"
                                        :_for_="passenger.id.toString()"
                                    />
                                    <InputError class="mt-2" :message="form.errors.first_name" />
                                </div>

                                <div class="w-full lg:w-1/19 mt-5 lg:mt-0 border-b-2 pb-0.25">
                                    <MaterialUiInput
                                        :id="passengerInputAttributes.last_name.id + passenger.id"
                                        v-model="form.passengers[passenger.id-1].last_name"
                                        :type="passengerInputAttributes.last_name.type"
                                        class="mt-1 block"
                                        :customClasses="passengerInputAttributes.last_name.customClasses"
                                        :label="passengerInputAttributes.last_name.label"
                                        :_for_="passenger.id.toString()"
                                    />
                                    <InputError class="mt-2" :message="form.errors.last_name" />
                                </div>
                            </div>

                        </div>

                        <div id="submit-button-box" class="flex items-center justify-between mt-4 mr-10">
                            <span class="text-sm text-custom_blue relative bottom-5 ml-10">* Required information</span>
                            <PrimaryButton class="ml-4 mb-10"
                                           :class="{ 'opacity-25': form.processing }"
                                           :disabled="form.processing">
                                Continue
                            </PrimaryButton>
                        </div>
                    </form>
                </div>

                <div class="w-full lg:w-9/12 mt-10 bg-whitesmoke mx-auto lg:rounded-lg shadow-3xl relative bottom-5">
                    <h1 class="w-full h-20 text-whitesmoke bg-custom_blue relative pl-6 text-lg lg:text-2xl font-semibold
                           pt-6 lg:rounded-t-lg">
                        <font-awesome-icon :icon="['fas', 'envelope']" class="pr-5" />
                        Contact
                    </h1>

                    <form @submit.prevent="submitContact" id="contact-box" class="hidden">
                        <h2 class="text-xs lg:text-sm font-normal text-custom_blue mb-5 px-10 py-5">
                            Please provide the contact details of the person who will receive your booking confirmation and travel information.
                        </h2>
                        <div class="flex justify-between px-10 py-1 mobile">
                            <div class="w-full lg:w-1/3.3 h-full">
                                <div class="w-full border-b-2 pb-0.25">
                                    <MaterialUiSelect
                                        :id="contactPersonInputAttributes.country_code.id"
                                        v-model="form.country_code"
                                        class="mt-1 block"
                                        :customClasses="contactPersonInputAttributes.country_code.customClasses"
                                        :label="contactPersonInputAttributes.country_code.label"
                                        :optionType="countryCodes"
                                    />
                                </div>
                            </div>

                            <div class="w-full lg:w-1/3.3 h-full">
                                <div class="w-full mt-5 lg:mt-0 border-b-2 pb-0.25">
                                    <MaterialUiInput
                                        :id="contactPersonInputAttributes.phone_number.id"
                                        v-model="form.phone_number"
                                        :type="contactPersonInputAttributes.phone_number.type"
                                        class="mt-1 block"
                                        :customClasses="contactPersonInputAttributes.phone_number.customClasses"
                                        :label="contactPersonInputAttributes.phone_number.label"
                                    />
                                    <InputError class="mt-2" :message="form.errors.phone_number" />
                                </div>
                                <span class="text-xs text-custom_blue pl-2">ex: 123456789</span>
                            </div>

                            <div class="w-full lg:w-1/3.3 h-full">
                                <div class="w-full mt-5 lg:mt-0 border-b-2 pb-0.25">
                                    <MaterialUiInput
                                        :id="contactPersonInputAttributes.email.id"
                                        v-model="form.email_address"
                                        :type="contactPersonInputAttributes.email.type"
                                        class="mt-1 block"
                                        :customClasses="['border-b-custom_blue', 'focus:border-b-lightskyblue', 'text-custom_blue']"
                                        :label="inputLabel.email_label"
                                    />
                                    <InputError class="mt-2" :message="form.errors.email" />
                                </div>
                            </div>
                        </div>

                        <div id="submit-button-box" class="flex items-center justify-between mt-4 mr-10">
                            <span class="text-sm text-custom_blue relative bottom-5 ml-10">* Required information</span>
                            <PrimaryButton class="ml-4 mb-10"
                                           :class="{ 'opacity-25': form.processing }"
                                           :disabled="form.processing">
                                Continue
                            </PrimaryButton>
                        </div>
                    </form>
                </div>

                <!-- Booking helper -->

                <div class="w-full lg:w-9/12 h-auto mx-auto p-5 bg-whitesmoke mt-5 relative bottom-5 text-custom_blue
                            lg:rounded-lg shadow-3xl"
                >
                    <div class="mb-5">
                        <font-awesome-icon :icon="['fas', 'phone-volume']" />
                        <span class="text-sm lg:text-xl px-2 uppercase font-semibold">
                            Need help with your booking?
                        </span>
                    </div>
                    <p>Lorem Airlines Service Line:<span class="font-bold px-2">+13 222 123 69</span></p>
                    <div class="py-2">
                        <p class="inline font-semibold mr-2">Opening hours:</p>
                        <span> Monday to Friday (08:00 AM - 08:00 PM)</span>
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
@media(max-width: 450px) {
    .mobile {
        flex-direction: column;
    }
}
</style>

