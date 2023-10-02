<script setup>
import { onMounted, watch } from "vue";
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '../../Layouts/AppLayout.vue';
import ProgressBar from  '../../Components/ProgressBar.vue';
import PrimaryButton from '../../Components/PrimaryButton.vue';
import SecondaryButton from '../../Components/SecondaryButton.vue';
import SectionBorder from '../../Components/SectionBorder.vue';
import Checkbox from '../../Components/Checkbox.vue';
import InputError from '../../Components/InputError.vue';

const props = defineProps({
    progressId: String,
    title: String,
    cost: String,
    isPrivate: Boolean,
    reservationNumber: String,
    airplaneUsefulPayload: Number,
    passengers: Object,
    baggages: Object,
    checkedBaggagePrice: Number,
    insurances: Object
});

const criticalPayloadValue = 0.2;
const checkBaggageWeight = parseInt(props.baggages.checkedBaggage.weight.split('/')[0]);
const checkedBaggageInsurancePrice = parseInt(props.baggages.checkedBaggage.price.split('$')[0]);

const form = useForm({
    passengers: props.passengers,
    airplaneUsefulPayload: props.airplaneUsefulPayload,
    insurances: props.insurances,
    noInsurance: false,
    selectedInsurances: [],
    cost: parseInt(props.cost)
});

watch(form, (newData) => {
    const selectInsuranceButtons = document.querySelectorAll('.select-insurance');
    const payload = document.getElementById('airplane-useful-payload');
    const alertBox = document.getElementById('alert-box');

    if(newData) {
        selectInsuranceButtons.forEach((item) => {
            item.disabled = form.noInsurance || item.classList.contains('inactive');
        });
    }

    if(form.noInsurance){
        form.errors.noInsurance = '';
    }

    if(form.airplaneUsefulPayload <= props.airplaneUsefulPayload * criticalPayloadValue) {
        payload.classList.add('text-danger');
        alertBox.classList.replace('hidden', 'block');
    } else {
        payload.classList.remove('text-danger');
    }
});

const incerement = (id) => {
    if(form.airplaneUsefulPayload >= (props.airplaneUsefulPayload * criticalPayloadValue) + checkBaggageWeight) {
        form.passengers[id].checkedBaggage += 1;
        form.passengers[id].checkedBaggagePrice += props.checkedBaggagePrice;
        form.cost += props.checkedBaggagePrice;
        document.getElementById('checked-baggage-price-' + id)
            .classList.replace('invisible', 'visible');
        form.insurances.luggage += checkedBaggageInsurancePrice;
        form.insurances.luggageAndTravel += checkedBaggageInsurancePrice;
        form.airplaneUsefulPayload -= checkBaggageWeight;
    } else {
        form.passengers[id].checkedBaggage += 0;
        form.passengers[id].checkedBaggagePrice += 0;
        form.airplaneUsefulPayload = props.airplaneUsefulPayload * criticalPayloadValue;
    }
}

const decrement = (id) => {
    let emptyCheckBaggageLength = 0;

    if(form.passengers[id].checkedBaggage > 0) {
        form.passengers[id].checkedBaggage -= 1
        form.passengers[id].checkedBaggagePrice -= props.checkedBaggagePrice;
        form.cost -= props.checkedBaggagePrice;
        form.insurances.luggage -= checkedBaggageInsurancePrice;
        form.insurances.luggageAndTravel -= checkedBaggageInsurancePrice;
        form.airplaneUsefulPayload += checkBaggageWeight
    } else {
        form.passengers[id].checkedBaggage = 0;
    }

    for (const id in form.passengers) {
        if(form.passengers[id].checkedBaggage === 0) {
            emptyCheckBaggageLength += 1;
            document.getElementById('checked-baggage-price-' + id)
                .classList.replace('visible', 'invisible');
            form.passengers[id].checkedBaggagePrice = 0;
        }
    }

    if(emptyCheckBaggageLength === Object.keys(form.passengers).length) {
        form.airplaneUsefulPayload = props.airplaneUsefulPayload
        form.passengers[id].isCheckedBaggagePrice = false;
    }
}

onMounted(() => {
    if(!props.isPrivate) {
        const inForth = document.getElementById('in-forth');
        const back = document.getElementById('back');

        inForth.addEventListener('click', () => {
            back.classList.remove('border-rebecca_purple');
            back.classList.replace('text-rebecca_purple', 'text-custom_blue');

            inForth.classList.add('border-rebecca_purple');
            inForth.classList.replace('text-custom_blue', 'text-rebecca_purple');
        });

        back.addEventListener('click', () => {
            inForth.classList.remove('border-rebecca_purple');
            inForth.classList.replace('text-rebecca_purple', 'text-custom_blue');

            back.classList.add('border-rebecca_purple');
            back.classList.replace('text-custom_blue', 'text-rebecca_purple');
        });
    }

});

const addBaggage = () => {
 const addBaggage = document.getElementById('add-baggage');
 addBaggage.classList.replace('hidden', 'block');
}

const closeAlertBox = () => {
    const alertBox = document.getElementById('alert-box');
    alertBox.classList.replace('block', 'hidden');
}

const select = (id) => {
    const insurance = document.getElementById(id);
    const selectInsuranceButtons = document.querySelectorAll('.select-insurance');
    const checkBox = document.getElementById('noInsurance');
    form.selectedInsurances = [];

    insurance.classList.add('border-success');
    insurance.children[4].classList.add('hidden');

    selectInsuranceButtons.forEach((item) => {
       item.classList.add('inactive');
    });

    checkBox.disabled = true;
    insurance.lastChild.classList.remove('hidden');
    insurance.lastChild.classList.add('hover:bg-transparent', 'h-8');

    form.selectedInsurances.push({
        name: insurance.firstElementChild.textContent,
        price: insurance.children[1].textContent.split(' ')[1].split('.')[0]
    });

    form.cost += parseInt(insurance.children[1].textContent.split(' ')[1].split('.')[0]);
    form.errors.noInsurance = '';
}

const remove = (id) => {
    const insurance = document.getElementById(id);
    const selectInsuranceButtons = document.querySelectorAll('.select-insurance');
    const checkBox = document.getElementById('noInsurance');

    insurance.classList.remove('border-success');
    insurance.children[4].classList.remove('hidden');

    selectInsuranceButtons.forEach((item) => {
        item.classList.remove('inactive');
    });

    checkBox.disabled = false;
    insurance.lastChild.classList.add('hidden');
    insurance.lastChild.classList.remove('hover:bg-transparent', 'h-8');
    form.cost -= parseInt(insurance.children[1].textContent.split(' ')[1].split('.')[0]);
    form.selectedInsurances = [];
}

const send = () => {
    const payload = document.getElementById('airplane-useful-payload');
    const alertBox = document.getElementById('alert-box');

    if(payload.classList.contains('text-danger')) {
        alertBox.classList.replace('hidden', 'block');
    }

    if(form.noInsurance) form.selectedInsurances = [];

    if(!form.noInsurance && form.selectedInsurances.length === 0){
        form.errors.noInsurance = 'Please select at least one insurance option or if you do not want to take out insurance check it.';
    }

    if(!form.errors.noInsurance){
        form.post(route('create-new-reservation-cost'));
    }
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
                />

                <div class="w-full lg:w-9/12 mt-30 bg-whitesmoke mx-auto p-5 lg:rounded-lg shadow-3xl relative bottom-5">
                    <h1 class="w-full h-20 text-custom_blue relative text-lg lg:text-2xl
                               font-bold pt-6 lg:rounded-t-lg"
                    >
                        Customize your trip
                    </h1>
                    <div class="w-full h-1/8 bg-ancillariesHeader bg-cover bg-no-repeat">
                        <div class="w-full h-full">
                            <div class="extra-baggage bg-whitesmoke border-2">
                                <h1 class="w-1/2 h-16 text-custom_blue relative text-lg lg:text-2xl
                               font-semibold pt-6 lg:rounded-t-lg pl-5"
                                >
                                    Add an additional checked bag starting at {{ checkedBaggagePrice }} USD
                                </h1>
                                <h2 class="w-1/4 h-16 relative text-sm text-custom_blue lg:text-lg
                                           font-medium pt-6 lg:rounded-t-lg pl-5 mt-5"
                                >
                                    Luggage is the cheapest
                                    <span class="text-info text-sm lg:text-lg font-semibold">{{ checkedBaggagePrice }} USD</span>
                                </h2>

                                <PrimaryButton class="ml-4 my-10"
                                               @click="addBaggage()"
                                >
                                    Add checked baggage
                                </PrimaryButton>
                            </div>

                        </div>
                    </div>

                    <!-- Add baggage -->

                    <div id="add-baggage" class="w-full h-auto mt-5 hidden">
                        <h1 v-if="isPrivate" class="text-custom_blue font-medium">
                            Selected airplane remainder useful payload capacity (max weight):
                            <span id="airplane-useful-payload"
                                  class="font-bold text-sm lg:text-lg">{{ form.airplaneUsefulPayload }}</span>
                            kg
                        </h1>
                        <div v-else class="w-full h-10 border-b-2">
                            <span id="in-forth"
                                  class="text-xs lg:text-sm text-rebecca_purple p-4 border-b-2 cursor-pointer
                                         border-rebecca_purple"
                            >
                                Budapest to Paris
                            </span>
                            <span id="back"
                                  class="text-xs lg:text-sm text-custom_blue p-4 border-b-2 cursor-pointer"
                            >
                                Paris to Budapest
                            </span>
                        </div>
                        <div v-for="passenger in passengers" :key="passenger.id"
                             class="w-full h-42 flex justify-between items-center border-b-2">
                            <span class="text-custom_blue ml-10">{{ passenger.name }}</span>
                            <div class="w-1/2 h-full flex justify-around mr-10">
                                <div class="w-1/3 flex-col">
                                    <div class="w-full h-1/3 my-3 flex justify-center">
                                        <font-awesome-icon class="text-custom_blue text-5xl mt-auto"
                                                           :icon="['fas', 'suitcase-rolling']" />
                                    </div>
                                    <p class="text-custom_blue text-center my-3">Hand baggage</p>
                                    <p class="text-custom_blue text-center my-3">1 x</p>
                                </div>
                                <div class="w-1/3 flex-col">
                                    <div class="w-full h-1/3 my-3 flex justify-center">
                                        <font-awesome-icon class="text-custom_blue text-3xl mt-auto"
                                                           :icon="['fas', 'briefcase']" />
                                    </div>
                                    <p class="text-custom_blue text-center my-3">Accessory</p>
                                    <p class="text-custom_blue text-center my-3">1 x</p>
                                </div>
                                <div class="w-1/3 flex-col">
                                    <div class="w-full h-1/3 my-3 flex justify-center">
                                        <font-awesome-icon class="text-custom_blue text-5xl mt-auto"
                                                           :icon="['fas', 'cart-flatbed-suitcase']" />
                                    </div>
                                    <p class="text-custom_blue text-center my-3">Checked baggage</p>
                                    <div class="w-full h-1/8 flex justify-around items-center my-1 pt-1">
                                        <font-awesome-icon class="bg-custom_blue text-whitesmoke rounded-full p-1
                                                                  cursor-pointer"
                                                           :icon="['fas', 'minus']"
                                                           @click="decrement(passenger.id)"
                                        />
                                        <p class="text-custom_blue text-center my-3">
                                            {{ form.passengers[passenger.id].checkedBaggage }} x
                                        </p>
                                        <font-awesome-icon class="bg-rebecca_purple text-whitesmoke rounded-full p-1
                                                                  cursor-pointer"
                                                           :icon="['fas', 'plus']"
                                                           @click="incerement(passenger.id)"
                                        />
                                    </div>
                                    <p :id="'checked-baggage-price-' + passenger.id"
                                       class="invisible text-custom_blue text-center font-semibold pt-2"
                                    >
                                        {{ form.passengers[passenger.id].checkedBaggagePrice.toFixed(2) }} USD
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Alert box -->

                        <div id="alert-box"
                             class="w-1/2 h-40 bg-whitesmoke fixed left-1/4 mx-auto bottom-1/3 z-10
                                    shadow-2xl hidden"
                        >
                            <div class="w-full h-10 bg-custom_blue flex justify-between">
                                <img class="h-10 p-1 ml-2" src="/img/logos/alert.png" alt="alert icon">
                                <font-awesome-icon class="w-4 h-4 rounded-full bg-danger text-whitesmoke p-1 mr-3
                                                          my-auto"
                                                   :icon="['fas', 'xmark']"
                                                   @click="closeAlertBox"
                                />
                            </div>
                            <h1 class="text-custom_blue text-sm lg:text-base text-center py-4">
                                Warning, the critical 80% loading level has been reached. Please remove a package.
                            </h1>
                            <PrimaryButton class="float-right mr-3 -my-1 select-insurance"
                                           @click="closeAlertBox"
                            >
                                Ok
                            </PrimaryButton>
                        </div>

                        <!-- Baggage guidlines -->

                        <div class="w-full h-auto mt-5 p-5 bg-gray-200">
                            <h1 class="w-full h-10 text-dark relative text-lg lg:text-2xl
                              font-semibold">Baggage guidlines*</h1>

                            <div class="w-full h-auto flex justify-between mt-5">
                                <div class="w-1/2 flex-col">
                                    <div class="w-full flex">
                                        <font-awesome-icon class="text-dark text-5xl mt-auto mr-5"
                                                           :icon="['fas', 'suitcase-rolling']" />
                                        <font-awesome-icon class="text-dark text-3xl mt-auto"
                                                           :icon="['fas', 'briefcase']" />
                                    </div>
                                    <h2 class="text-dark text-base lg:text-lg font-semibold py-5">
                                        Hand baggage & accessory
                                    </h2>
                                    <div v-if="isPrivate" class="mb-5">
                                        <p class="text-dark text-xs lg:text-sm">
                                            Max. weight in the Airplane cabin:
                                            {{ baggages.handBaggage.weight.split('/')[0] }}/
                                            {{ baggages.handBaggage.weight.split('/')[1] }}
                                        </p>
                                    </div>
                                    <div v-else class="mb-5">
                                        <p class="text-dark text-xs lg:text-sm">
                                            Max. weight in the Economy cabin: kg/lb
                                        </p>
                                        <p class="text-dark text-xs lg:text-sm">
                                            Max. weight in the Business cabin: kg/lb
                                        </p>
                                    </div>
                                    <h3 class="text-dark text-sm lg:text-base font-semibold">
                                        Hand baggage dimensions:
                                    </h3>
                                    <p class="text-dark text-xs lg:text-sm">
                                        {{ baggages.handBaggage.height.split('/')[0].split('cm')[0] }} x
                                        {{ baggages.handBaggage.width.split('/')[0].split('cm')[0] }} x
                                        {{ baggages.handBaggage.depth.split('/')[0].split('cm')[0] }} x cm /
                                        {{ baggages.handBaggage.height.split('/')[1].split('inch')[0] }} x
                                        {{ baggages.handBaggage.width.split('/')[1].split('inch')[0] }} x
                                        {{ baggages.handBaggage.depth.split('/')[1].split('inch')[0] }} x in
                                    </p>
                                    <h3 class="text-dark text-sm lg:text-base font-semibold">
                                        Accessory dimensions:
                                    </h3>
                                    <p class="text-dark text-xs lg:text-sm">
                                        {{ baggages.accessory.height.split('/')[0].split('cm')[0] }} x
                                        {{ baggages.accessory.width.split('/')[0].split('cm')[0] }} x
                                        {{ baggages.accessory.depth.split('/')[0].split('cm')[0] }} x cm /
                                        {{ baggages.accessory.height.split('/')[1].split('inch')[0] }} x
                                        {{ baggages.accessory.width.split('/')[1].split('inch')[0] }} x
                                        {{ baggages.accessory.depth.split('/')[1].split('inch')[0] }} x in
                                    </p>

                                </div>
                                <div class="w-1/2 flex-col">
                                    <font-awesome-icon class="text-dark text-5xl mt-auto"
                                                       :icon="['fas', 'cart-flatbed-suitcase']" />
                                    <h2 class="text-dark text-base lg:text-lg font-semibold py-5">
                                        Checked baggage
                                    </h2>
                                    <div v-if="isPrivate" class="mb-5">
                                        <p class="text-dark text-xs lg:text-sm">
                                            Max. weight in the Airplane cabin:
                                            {{ baggages.checkedBaggage.weight.split('/')[0] }}/
                                            {{ baggages.checkedBaggage.weight.split('/')[1] }} (per item).
                                        </p>
                                    </div>
                                    <div v-else class="mb-5">
                                        <p class="text-dark text-xs lg:text-sm">
                                            Max. weight in the Economy cabin: kg/lb (per item).
                                        </p>
                                        <p class="text-dark text-xs lg:text-sm">
                                            Max. weight in the Business cabin: kg/lb (per item).
                                        </p>
                                    </div>
                                    <h3 class="text-dark text-sm lg:text-base font-semibold">
                                        Checked baggage dimensions:
                                    </h3>
                                    <p class="text-dark text-xs lg:text-sm">
                                        {{ baggages.checkedBaggage.height.split('/')[0].split('cm')[0] }} x
                                        {{ baggages.checkedBaggage.width.split('/')[0].split('cm')[0] }} x
                                        {{ baggages.checkedBaggage.depth.split('/')[0].split('cm')[0] }} x cm /
                                        {{ baggages.checkedBaggage.height.split('/')[1].split('inch')[0] }} x
                                        {{ baggages.checkedBaggage.width.split('/')[1].split('inch')[0] }} x
                                        {{ baggages.checkedBaggage.depth.split('/')[1].split('inch')[0] }} x in
                                    </p>
                                </div>
                            </div>
                        </div>
                        <SectionBorder borderColor="border-info" />
                        <p class="text-custom_blue text-sm relative bottom-0 lg:bottom-7">
                            *Applies to flights operated by Lorem Airlines only. For other airlines, please check for the airline's website for baggage regulations.
                        </p>
                    </div>

                    <!-- Select insurance -->

                    <h1 class="w-full h-10 text-custom_blue relative text-lg lg:text-2xl
                              font-semibold mt-20 lg:mt-10">Insure your trip</h1>
                    <h2 class="w-full h-5 mb-10 text-custom_blue relative text-sm lg:text-lg
                              font-medium">Select insurance for your travel</h2>

                    <div class="w-full h-1/4 flex justify-between insurance-card-box">
                        <div id="luggage-insurance" class="w-1/2 lg:w-1/3 h-50 border-2 lg:mr-2">
                            <h2 class="w-full h-20 text-custom_blue relative text-sm lg:text-lg
                              font-medium pt-2 lg:rounded-t-lg pl-3">Lugagge insurance</h2>
                            <h1 class="w-full h-6 text-custom_blue relative text-sm lg:text-lg
                              font-bold pt-2 lg:rounded-t-lg pl-3">USD {{ form.insurances.luggage.toFixed(2) }}</h1>
                            <span class="text-custom_blue text-xs pl-3">total for all passengers</span>
                            <div class="w-full h-28 flex-col justify-between mt-3">
                                <div class="ml-3">
                                    <font-awesome-icon class="text-success" :icon="['fas', 'check']" />
                                    <span class="text-custom_blue text-xs pl-3">Injuring baggage</span>
                                </div>
                                <div class="ml-3">
                                    <font-awesome-icon class="text-success" :icon="['fas', 'check']" />
                                    <span class="text-custom_blue text-xs pl-3">Missing baggage</span>
                                </div>
                                <div class="ml-3">
                                    <font-awesome-icon class="text-danger" :icon="['fas', 'xmark']" />
                                    <span class="text-custom_blue text-xs pl-3.5">Medical coverage</span>
                                </div>
                                <div class="ml-3">
                                    <font-awesome-icon class="text-danger" :icon="['fas', 'xmark']" />
                                    <span class="text-custom_blue text-xs pl-3.5">Cancellation coverage</span>
                                </div>
                            </div>
                            <PrimaryButton class="float-right mr-3 my-3 select-insurance"
                                           @click="select('luggage-insurance')"
                            >
                                Select
                            </PrimaryButton>
                            <SecondaryButton class="hidden float-right mr-3 my-3"
                                             @click="remove('luggage-insurance')"
                            >
                                Remove
                            </SecondaryButton>
                        </div>
                        <div id="travel-insurance" class="w-1/2 lg:w-1/3 h-50 border-2 lg:mx-2">
                            <h2 class="w-full h-20 text-custom_blue relative text-sm lg:text-lg
                              font-medium pt-2 lg:rounded-t-lg pl-3">Travel insurance</h2>
                            <h1 class="w-full h-6 text-custom_blue relative text-sm lg:text-lg
                              font-bold pt-2 lg:rounded-t-lg pl-3">USD {{ insurances.travel.toFixed(2) }}</h1>
                            <span class="text-custom_blue text-xs pl-3">total for all passengers</span>
                            <div class="w-full h-28 flex-col justify-between mt-3">
                                <div class="ml-3">
                                    <font-awesome-icon class="text-danger" :icon="['fas', 'xmark']" />
                                    <span class="text-custom_blue text-xs pl-3.5">Injuring baggage</span>
                                </div>
                                <div class="ml-3">
                                    <font-awesome-icon class="text-danger" :icon="['fas', 'xmark']" />
                                    <span class="text-custom_blue text-xs pl-3.5">Missing baggage</span>
                                </div>
                                <div class="ml-3">
                                    <font-awesome-icon class="text-success" :icon="['fas', 'check']" />
                                    <span class="text-custom_blue text-xs pl-3">Medical coverage</span>
                                </div>
                                <div class="ml-3">
                                    <font-awesome-icon class="text-success" :icon="['fas', 'check']" />
                                    <span class="text-custom_blue text-xs pl-3">Cancellation coverage</span>
                                </div>
                            </div>
                            <PrimaryButton class="float-right mr-3 my-3 select-insurance"
                                           @click="select('travel-insurance')"
                            >
                                Select
                            </PrimaryButton>
                            <SecondaryButton class="hidden float-right mr-3 my-3"
                                             @click="remove('travel-insurance')"
                            >
                                Remove
                            </SecondaryButton>
                        </div>
                        <div id="luggage-and-travel-insurance"
                             class="w-1/2 lg:w-1/3 h-50 border-2 lg:ml-2 overflow-hidden">
                            <h2 class="w-full h-20 text-custom_blue relative text-sm lg:text-lg
                              font-medium pt-2 lg:rounded-t-lg pl-3">Lugagge and travel insurance</h2>
                            <h1 class="w-full h-6 text-custom_blue relative text-sm lg:text-lg
                              font-bold pt-2 lg:rounded-t-lg pl-3">USD {{ form.insurances.luggageAndTravel.toFixed(2) }}</h1>
                            <span class="text-custom_blue text-xs pl-3">total for all passengers</span>
                            <div class="w-full h-28 flex-col justify-between mt-3">
                                <div class="ml-3">
                                    <font-awesome-icon class="text-success" :icon="['fas', 'check']" />
                                    <span class="text-custom_blue text-xs pl-3">Injuring baggage</span>
                                </div>
                                <div class="ml-3">
                                    <font-awesome-icon class="text-success" :icon="['fas', 'check']" />
                                    <span class="text-custom_blue text-xs pl-3">Missing baggage</span>
                                </div>
                                <div class="ml-3">
                                    <font-awesome-icon class="text-success" :icon="['fas', 'check']" />
                                    <span class="text-custom_blue text-xs pl-3">Medical coverage</span>
                                </div>
                                <div class="ml-3">
                                    <font-awesome-icon class="text-success" :icon="['fas', 'check']" />
                                    <span class="text-custom_blue text-xs pl-3">Cancellation coverage</span>
                                </div>
                            </div>
                            <PrimaryButton class="float-right mr-3 my-3 select-insurance"
                                           @click="select('luggage-and-travel-insurance')"
                            >
                                Select
                            </PrimaryButton>
                            <SecondaryButton class="hidden float-right mr-3 my-3"
                                             @click="remove('luggage-and-travel-insurance')"
                            >
                                Remove
                            </SecondaryButton>
                        </div>
                    </div>

                    <div class="w-full h-auto my-10 pb-5">
                        <label class="flex items-center">
                            <Checkbox id="noInsurance" v-model:checked="form.noInsurance" name="noInsurance" />
                            <span class="ml-2 text-sm text-custom_blue">No thanks, I don't want to add any insurance.</span>
                        </label>
                        <p class="text-xs text-custom_blue px-6">
                            I understand, will give you a complete account of the system, and expound the actual teachings of the great explorer.
                        </p>
                        <div v-if="form.errors.noInsurance" class="w-full flex py-5">
                            <font-awesome-icon :icon="['fas', 'circle-exclamation']" class="text-danger" />
                            <InputError :message="form.errors.noInsurance" class="pl-1" />
                        </div>
                    </div>

                    <div class="w-full h-auto bg-gray-200 py-1 px-2">
                        <p class="text-sm text-dark underline pb-1">By selecting this insurance I confirm:</p>
                        <ul>
                            <li class="text-xs text-dark list-disc list-outside ml-5">
                                <p>I have read and accept the insurance product information document, terms and conditions and privacy statement, provided digitally.</p>
                            </li>
                            <li class="text-xs text-dark list-disc list-outside ml-5">
                                <p>I have verified that the insurance corresponds to my needs.</p>
                            </li>
                        </ul>
                    </div>

                    <img class="h-18 ml-auto"
                         src="/img/logos/travel-insurance.png"
                         alt="insurance logo"
                    >
                    <span class="text-xs relative bottom-4 float-right">powered by Travel Insurance Corp.</span>

                </div>

                <div class="w-full lg:w-9/12 h-16 mx-auto bg-transparent mt-5 relative bottom-2">
                    <PrimaryButton class="float-right mr-3 my-3"
                                   @click="send"
                    >
                        Continue
                    </PrimaryButton>
                </div>

                <!-- Help -->

                <div class="w-full lg:w-9/12 h-auto mx-auto p-3 bg-whitesmoke mt-5 relative bottom-5 text-custom_blue
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
                    <p>Please provide your booking reference when you call:
                        <span class="font-bold">{{ reservationNumber }}</span>
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.extra-baggage {
    -webkit-clip-path: polygon(0 0%, 60% 0%, 40% 100%, 0% 100%);
    clip-path: polygon(0 0%, 60% 0%, 40% 100%, 0% 100%);
}

@media(max-width: 750px) {
    .insurance-card-box {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .insurance-card-box div {
        margin-top: 10px;
    }
}

@media(max-width: 540px) {
    .insurance-card-box div {
        width: 100%;
    }
}
</style>
