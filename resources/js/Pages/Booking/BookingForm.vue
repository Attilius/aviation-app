<script setup>
import { onMounted, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { travelTypes, cabinClasses } from "../../Config/selectOption.js";
import FormTemplate from '../../Components/FormTemplate.vue';
import InputError from '../../Components/InputError.vue';
import PrimaryButton from '../../Components/PrimaryButton.vue';
import MaterialUiInput from '../../Components/MaterialUiInput.vue';
import MaterialUiSelect from '../../Components/MaterialUiSelect.vue';
import InputFilteredList from '../../Components/InputFilteredList.vue';
import ClearInput from '../../Components/ClearInput.vue';
import InputAttributesBuilder from "../../Utils/InputAttributesBuilder";

const props = defineProps({
    class_: String,
    btn_text: String,
    airports: Array,
    passengers: Array,
    valueOfPassengersField: String,
    isPrivate: Boolean
});

const emit = defineEmits(['updateAddPassengerBoxState', 'updatePassengers']);

const form = useForm({
    travel_type: '',
    departure_from: '',
    arriving_at: '',
    departure_date: '',
    return_date: '',
    passengers: '1 adult',
    cabin_class: '',
    departureInputStatus: '',
    arrivingInputStatus: '',
    departure_iata: '',
    arriving_iata: '',
    //terminal_d: 'A',
    //terminal_a: 'A',
    pax: '0-0-0-0-0',
    connections: '',
});

const inputAttributes = new InputAttributesBuilder('bookFlight').build();
let filteredAirports = [];

const createPassenger = () => {
    document.body.classList.add('stop-scrolling');
    emit('updateAddPassengerBoxState', 'block');
}

const getActualDateTime = (type = '') => {
    const now = new Date();

    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());

    switch (type) {
        case '': {
            return now.toISOString().slice(0,16);
        }
        case 'date': {
            return now.toISOString().slice(0,16).split('T')[0];
        }
        case 'time': {
            return now.toISOString().slice(0,16).split('T')[1];
        }
    }
}

onMounted(() =>{
    document.getElementById('process').classList.replace('block', 'hidden');
    document.getElementById('departure_date').value = getActualDateTime();
    document.getElementById('return_date').value = getActualDateTime();
});

watch(() => props.valueOfPassengersField, (newValue, oldValue) => {
    if (newValue) {
        form.passengers = newValue;
    } else {
        form.passengers = oldValue;
    }
});

watch(form, (newForm) => {
    const returnDate = document.getElementById('return-date');

    if (newForm.travel_type === 'one way') {
        returnDate.style.display = 'none';
    } else {
        returnDate.style.display = 'inline';
    }
});

watch(form, (newForm) => {
    const departureInput = document.getElementById(inputAttributes.departure_from.id);
    const arrivingInput = document.getElementById(inputAttributes.arriving_at.id);
    const departureInputList = document.getElementById('departureInputList');
    const arrivingInputList = document.getElementById('arrivingInputList')
    const departureHighlighterList = document.getElementById('departureInputList')
                                        .querySelector('.airports')
                                        .querySelectorAll('li');
    const arrivingHighlighterList = document.getElementById('arrivingInputList')
                                       .querySelector('.airports')
                                       .querySelectorAll('li');

    if (newForm.departure_from || newForm.arriving_at) {
        airportFilter(departureInputList, newForm.departure_from, departureInput);
        filteredTextHighlighter(departureHighlighterList, newForm.departure_from);
        airportFilter(arrivingInputList, newForm.arriving_at, arrivingInput);
        filteredTextHighlighter(arrivingHighlighterList, newForm.arriving_at);
    }
});

const airportFilter = (listBox, wordPart, inputField) => {
    if (wordPart !== '' && wordPart.length > 0 && inputField === document.activeElement) {
        filteredAirports = props.airports.filter(
            item => {
                return  item.municipality.toString().toLowerCase().includes(wordPart.toLowerCase())||
                        item.name.toString().toLowerCase().includes(wordPart.toLowerCase()) ||
                        item.iata_code.toString().toLowerCase().includes(wordPart.toLowerCase());
            }
        );
        listBox.classList.replace('hidden', 'block');
        documentClickWatcher(listBox, inputField);
    } else {
        listBox.classList.replace('block', 'hidden');
    }
}

const filteredTextHighlighter = (list, wordPart) => {
    list.forEach((listItem) => {
        const cityAndAirportName = listItem.lastChild.lastChild.firstChild;
        const iataCodeText = listItem.lastChild.lastChild.lastChild;
        const regexp = new RegExp(wordPart, 'i');

        cityAndAirportName.innerHTML = cityAndAirportName.textContent.replace(regexp, '<b>$&</b>');
        iataCodeText.innerHTML = iataCodeText.textContent.replace(regexp, '<b>$&</b>');
    });
}

const documentClickWatcher = (listBox, inputField) => {
    document.addEventListener('click', (e)=> {
        if (e.target !== inputField && inputField.id === 'departure_from') {
            listBox.classList.replace('block', 'hidden');
            form.errors.departure_from = 'Please enter your place of departure (city).'
        }
        if (e.target !== inputField && inputField.id === 'arriving_at') {
            listBox.classList.replace('block', 'hidden');
            form.errors.arriving_at = 'Please enter your place of arriving (city).'
        }
        if (inputField.value === '' && inputField.id === 'departure_from') {
            form.errors.departure_from = 'Please enter your place of departure (city).'
        }
        if (inputField.value === '' && inputField.id === 'arriving_at') {
            form.errors.arriving_at = 'Please enter your place of arriving (city).'
        }
        if (form.departureInputStatus === 'correct value' && inputField.value !== '') {
            form.errors.departure_from = ''
        }
        if (form.arrivingInputStatus === 'correct value' && inputField.value !== '') {
            form.errors.arriving_at = ''
        }
    });
}

const setPax = (array) => {
    const intArray = [];

    form.pax.split('-').forEach((item) => {
        intArray.push(parseInt(item));
    });

    array.forEach((item) => {
        switch (item.type) {
            case 'Adult': {
                intArray[0] += 1;
                break;
            }
            case 'Child (2 - 11 years)': {
                intArray[1] += 1;
                break;
            }
            case 'Infant (0 - 23 months)': {
                intArray[2] += 1;
                break;
            }
            case 'Senior (65 years and Older)': {
                intArray[3] += 1;
                break;
            }
            case 'Youth (12 - 17 years)': {
                intArray[4] += 1;
                break;
            }
            default: {}
        }
    });

    form.pax = intArray.map((item) => item.toString()).join('-');

    emit('updatePassengers', [
        {
            id: 1,
            type: 'Adult'
        }
    ]);
}

// Emit event setters or updaters

function setDepIataCode(code) {
    form.departure_iata = code;
}

function setArrIataCode(code) {
    form.arriving_iata = code;
}

function editInputValueStatus(status) {
    if (status[1] === 'departureInputList') {
        form.departureInputStatus = status[0];
    }
    if (status[1] === 'arrivingInputList') {
        form.arrivingInputStatus = status[0];
    }
}

function resetInputError(error) {
    switch (error[1]) {
        case 'travel_type': {
            form.errors.travel_type = error[0];
            break;
        }
        case 'departureInputList': {
            form.errors.departure_from = error[0];
            break;
        }
        case 'arrivingInputList': {
            form.errors.arriving_at = error[0];
            break;
        }
        case 'departure_date': {
            form.errors.departure_date = error[0];
            break;
        }
        case 'return_date': {
            form.errors.return_date = error[0];
            break;
        }
        default: {}
    }
}

function resetModelValue (value) {
    if (value[1] === 'departureClearInputBox') {
        form.departure_from = value[0];
    }
    if (value[1] === 'arrivingClearInputBox') {
        form.arriving_at = value[0];
    }
}

const inputErrorMessageSetter = () => {
    const travelType = document.getElementById('travel_type');
    const departureFrom = document.getElementById('departure_from');
    const arrivingAt = document.getElementById('arriving_at');
    const departureDate = document.getElementById('departure_date');

    if(travelType.value === '') {
        form.errors.travel_type = 'Please select type.'
        return "Form is invalid"
    }

    if(departureFrom.value === '') {
        form.errors.departure_from = 'Please enter your place of departure (city).'
        return "Form is invalid"
    }

    if(arrivingAt.value === '') {
        form.errors.arriving_at = 'Please enter your place of arriving (city).'
        return "Form is invalid"
    }

    if(departureDate.value === getActualDateTime() || form.departure_date === '') {
        form.errors.departure_date = 'Please choose date of your departing.'
        return "Form is invalid"
    }

    if(form.return_date === '' && travelType.value === 'round trip') {
        form.errors.return_date = 'Please choose date of your return.'
        return "Form is invalid"
    }

    return 'Form is valid'
}

// Form submit

const send = () => {
    if(inputErrorMessageSetter() === 'Form is valid') {
        document.getElementById('process').classList.replace('hidden', 'block');
        setPax(props.passengers);

        if (form.travel_type.toLowerCase() === 'one way') {
            form.connections=`${form.departure_iata}>${form.arriving_iata}`;
            form.travel_type = 'ONEWAY';
        } else {
            form.connections=`${form.departure_iata}>${form.arriving_iata}-${form.arriving_iata}>${form.departure_iata}`;
            form.travel_type = 'ROUNDTRIP';
        }

        delete form.departure_from;
        delete form.arriving_at;
        delete form.passengers;
        delete form.cabin_class;
        delete form.departureInputStatus;
        delete form.arrivingInputStatus;
        delete form.departure_iata;
        delete form.arriving_iata;

        form.get(route('plane-choosing'), {
            onFinish: () => form.reset(),
        });
    }
};
</script>

<template>
    <FormTemplate :class="class_">
        <template #form>

            <!-- Travel type -->

            <div class="col-span-5 lg:col-span-2">
                <div class="flex border-b-2 pb-0.25 capitalize"
                     :class="form.errors.travel_type ? 'border-danger' : 'border-custom_blue'"
                >
                    <MaterialUiSelect
                        :id="inputAttributes.travel_type.id"
                        v-model="form.travel_type"
                        class="mt-1 block w-full"
                        :customClasses="inputAttributes.return_date.customClasses"
                        :label="inputAttributes.travel_type.label"
                        :optionType="travelTypes"
                        :error="form.errors.travel_type"
                        @updateInputError="resetInputError"

                    />
                </div>
                <div v-if="form.errors.travel_type" class="w-full flex justify-center items-center pt-1 text-xs">
                    <font-awesome-icon :icon="['fas', 'circle-exclamation']" class="text-danger" />
                    <InputError :message="form.errors.travel_type" class="pl-1" />
                </div>
            </div>

            <!-- Departure -->

            <div class="flex-col col-span-5 lg:col-span-5">
                <div class="flex border-b-2 pb-0.25"
                     :class="form.errors.departure_from ? 'border-danger' : 'border-custom_blue'"
                >
                    <i class="material-icons prefix mr-1 relative top-3.5 text-2xl"
                       :class="form.errors.departure_from ? 'text-danger' : 'text-custom_blue'"
                    >
                        flight_takeoff
                    </i>
                    <MaterialUiInput
                        :id="inputAttributes.departure_from.id"
                        :type="inputAttributes.departure_from.type"
                        v-model="form.departure_from"
                        class="mt-1 block w-full"
                        :customClasses="inputAttributes.departure_from.customClasses"
                        :label="inputAttributes.departure_from.label"
                        :error="form.errors.departure_from"
                        :inputValueStatus="form.departureInputStatus"
                    />
                    <ClearInput id="departureClearInputBox"
                                :inputValueStatus="form.departureInputStatus"
                                :error="form.errors.departure_from"
                                v-model="form.departure_from"
                                @updateModelValue="resetModelValue"
                    />

                </div>
                <div v-if="form.errors.departure_from" class="w-full flex justify-center items-center pt-1 text-xs">
                    <font-awesome-icon :icon="['fas', 'circle-exclamation']" class="text-danger" />
                    <InputError :message="form.errors.departure_from" class="pl-1" />
                </div>

                <InputFilteredList id="departureInputList"
                                   v-model="form.departure_from"
                                   :inputError="form.errors.departure_from"
                                   :inputValueStatus="form.departureInputStatus"
                                   @updateIataCode="setDepIataCode"
                                   @updateInputError="resetInputError"
                                   @updateinputValueStatus="editInputValueStatus"
                                   :list="filteredAirports"
                />
            </div>

            <!-- Arriving -->

            <div class="flex-col col-span-5 lg:col-span-5">
                <div class="flex border-b-2 pb-0.25"
                     :class="form.errors.arriving_at ? 'border-danger' : 'border-custom_blue'"
                >
                    <i class="material-icons prefix mr-1 relative top-3.5 text-2xl"
                       :class="form.errors.arriving_at ? 'text-danger' : 'text-custom_blue'"
                    >
                        flight_land
                    </i>
                    <MaterialUiInput
                        :id="inputAttributes.arriving_at.id"
                        :type="inputAttributes.arriving_at.type"
                        v-model="form.arriving_at"
                        class="mt-1 block w-full"
                        :customClasses="inputAttributes.arriving_at.customClasses"
                        :label="inputAttributes.arriving_at.label"
                        :error="form.errors.arriving_at"
                        :inputValueStatus="form.arrivingInputStatus"
                    />
                    <ClearInput id="arrivingClearInputBox"
                                :inputValueStatus="form.arrivingInputStatus"
                                :error="form.errors.arriving_at"
                                v-model="form.arriving_at"
                                @updateModelValue="resetModelValue"
                    />

                </div>
                <div v-if="form.errors.arriving_at" class="w-full flex justify-center items-center pt-1 text-xs">
                    <font-awesome-icon :icon="['fas', 'circle-exclamation']" class="text-danger" />
                    <InputError :message="form.errors.arriving_at" class="pl-1" />
                </div>

                <InputFilteredList id="arrivingInputList"
                                   v-model="form.arriving_at"
                                   :inputError="form.errors.arriving_at"
                                   :inputValueStatus="form.arrivingInputStatus"
                                   @updateIataCode="setArrIataCode"
                                   @updateInputError="resetInputError"
                                   @updateinputValueStatus="editInputValueStatus"
                                   :list="filteredAirports"
                />
            </div>


            <!-- Departure date -->

            <div class="col-span-5"
                 :class="isPrivate ? 'lg:col-span-4' : 'lg:col-span-3'"
            >
                <div class="flex border-b-2 pb-0.25 h-10"
                     :class="form.errors.departure_date ? 'border-danger' : 'border-custom_blue'"
                >
                    <MaterialUiInput
                        v-if="isPrivate"
                        :id="inputAttributes.departure_date.id"
                        type="datetime-local"
                        v-model="form.departure_date"
                        class="mt-1 block w-full"
                        :customClasses="inputAttributes.departure_date.customClasses"
                        :label="inputAttributes.departure_date.label"
                        :error="form.errors.departure_date"
                        @updateInputError="resetInputError"
                    />

                    <MaterialUiInput
                        v-else
                        :id="inputAttributes.departure_date.id"
                        :type="inputAttributes.departure_date.type"
                        v-model="form.departure_date"
                        class="mt-1 block w-full"
                        :customClasses="inputAttributes.departure_date.customClasses"
                        :label="inputAttributes.departure_date.label"
                        :error="form.errors.departure_date"
                        @updateInputError="resetInputError"

                    />
                </div>
                <div v-if="form.errors.departure_date" class="w-full flex justify-center items-center pt-1 text-xs">
                    <font-awesome-icon :icon="['fas', 'circle-exclamation']" class="text-danger" />
                    <InputError :message="form.errors.departure_date" class="pl-1" />
                </div>
            </div>

            <!-- Return date -->

            <div id="return-date" class="col-span-5"
                 :class="isPrivate ? 'lg:col-span-4' : 'lg:col-span-3'"
            >
                <div class="flex border-b-2 pb-0.25 h-10"
                     :class="form.errors.return_date ? 'border-danger' : 'border-custom_blue'"
                >
                    <MaterialUiInput
                        v-if="isPrivate"
                        :id="inputAttributes.return_date.id"
                        type="datetime-local"
                        v-model="form.return_date"
                        class="mt-1 block w-full"
                        :customClasses="inputAttributes.return_date.customClasses"
                        :label="inputAttributes.return_date.label"
                        :error="form.errors.return_date"
                        @updateInputError="resetInputError"
                    />

                    <MaterialUiInput
                        v-else
                        :id="inputAttributes.return_date.id"
                        :type="inputAttributes.return_date.type"
                        v-model="form.return_date"
                        class="mt-1 block w-full"
                        :customClasses="inputAttributes.return_date.customClasses"
                        :label="inputAttributes.return_date.label"
                        :error="form.errors.return_date"
                        @updateInputError="resetInputError"
                    />
                </div>
                <div v-if="form.errors.return_date" class="w-full flex justify-center items-center pt-1 text-xs">
                    <font-awesome-icon :icon="['fas', 'circle-exclamation']" class="text-danger" />
                    <InputError :message="form.errors.return_date" class="pl-1" />
                </div>
            </div>

            <!-- Passengers -->

            <div class="flex col-span-5"
                 :class="isPrivate ? 'lg:col-span-4' : 'lg:col-span-3'"
            >
                <div class="w-full flex border-b-2 pb-0.25 border-custom_blue h-10">
                    <i class="material-icons prefix mr-1 relative top-3 text-2xl text-custom_blue">hail</i>
                    <MaterialUiInput
                        :id="inputAttributes.passengers.id"
                        :type="inputAttributes.passengers.type"
                        v-model="form.passengers"
                        class="mt-1 block w-full"
                        :basicValue="inputAttributes.passengers.value"
                        :customClasses="inputAttributes.passengers.customClasses"
                        :label="inputAttributes.passengers.label"
                        @click="createPassenger()"
                    />
                </div>
            </div>

            <!-- Cabin class -->

            <div v-if="!isPrivate" class="flex col-span-5 lg:col-span-3">
                <div class="w-full flex border-b-2 pb-0.25 h-10 border-custom_blue capitalize">
                    <i class="material-icons prefix mr-1 relative top-3 text-2xl text-custom_blue">
                        airline_seat_recline_extra
                    </i>
                    <MaterialUiSelect
                        :id="inputAttributes.cabin_class.id"
                        v-model="form.cabin_class"
                        class="mt-1 block w-full"
                        :customClasses="inputAttributes.cabin_class.customClasses"
                        :label="inputAttributes.cabin_class.label"
                        :optionType="cabinClasses"
                    />
                </div>
            </div>
        </template>

        <template #actions>
            <span class="text-xs md:text-sm text-custom_blue">* Required information</span>
            <PrimaryButton :class="{ 'opacity-25': form.processing }"
                           :disabled="form.processing"
                           @click="send()">
                {{ btn_text ? btn_text : 'Search flights' }}
            </PrimaryButton>
        </template>
    </FormTemplate>
</template>
