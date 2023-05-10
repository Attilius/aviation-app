<script setup>
import { watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import FormTemplate from '../../Components/FormTemplate.vue';
import InputError from '../../Components/InputError.vue';
import PrimaryButton from '../../Components/PrimaryButton.vue';
import MaterialUiInput from '../../Components/MaterialUiInput.vue';
import MaterialUiSelect from '../../Components/MaterialUiSelect.vue';
import InputAttributesBuilder from "../../Utils/InputAttributesBuilder";
import { travelTypes, cabinClasses } from "../../Config/selectOption.js";

const form = useForm({
    travel_type: '',
    departure_from: '',
    arriving_at: '',
    departure_date: '',
    return_date: '',
    passengers: '1 adult',
    cabin_class: ''
});

const inputAttributes = new InputAttributesBuilder('bookFlight').build();

const createPassenger = () => {
    console.log('A new passenger created...')
}

watch(form, (newForm) => {
    const returnDate = document.getElementById('return-date');

    if (newForm.travel_type === 'one way') {
        returnDate.style.display = 'none';
    } else {
        returnDate.style.display = 'inline';
    }
});

const send = () => {

    console.log(form)
};
</script>

<template>
    <FormTemplate class="book-form">
        <template #form>

            <!-- Travel type -->

            <div class="col-span-2 sm:col-span-2">
                <MaterialUiSelect
                    :id="inputAttributes.travel_type.id"
                    v-model="form.travel_type"
                    class="mt-1 block w-full"
                    :customClasses="inputAttributes.return_date.customClasses"
                    :label="inputAttributes.travel_type.label"
                    :optionType="travelTypes"
                />
                <InputError :message="form.errors.email" class="mt-2" />

            </div>

            <!-- Departure -->

            <div class="flex col-span-5 sm:col-span-5">
                <i class="material-icons prefix mr-1 relative top-3 text-2xl">flight_takeoff</i>
                <MaterialUiInput
                    :id="inputAttributes.departure_from.id"
                    :type="inputAttributes.departure_from.type"
                    v-model="form.departure_from"
                    class="mt-1 block w-full"
                    :customClasses="inputAttributes.departure_from.customClasses"
                    :label="inputAttributes.departure_from.label"
                />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Arriving -->

            <div class="flex col-span-5 sm:col-span-5">
                <i class="material-icons prefix mr-1 relative top-3 text-2xl">flight_land</i>
                <MaterialUiInput
                    :id="inputAttributes.arriving_at.id"
                    :type="inputAttributes.arriving_at.type"
                    v-model="form.arriving_at"
                    class="mt-1 block w-full"
                    :customClasses="inputAttributes.arriving_at.customClasses"
                    :label="inputAttributes.arriving_at.label"
                />
                <InputError :message="form.errors.email" class="mt-2" />

            </div>


            <!-- Departure date -->
            <div class="col-span-3 sm:col-span-3">
                <MaterialUiInput
                    :id="inputAttributes.departure_date.id"
                    :type="inputAttributes.departure_date.type"
                    v-model="form.departure_date"
                    class="mt-1 block w-full"
                    :customClasses="inputAttributes.departure_date.customClasses"
                    :label="inputAttributes.departure_date.label"
                />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Return date -->
            <div id="return-date" class="col-span-3 sm:col-span-3">
                <MaterialUiInput
                    :id="inputAttributes.return_date.id"
                    :type="inputAttributes.return_date.type"
                    v-model="form.return_date"
                    class="mt-1 block w-full"
                    :customClasses="inputAttributes.return_date.customClasses"
                    :label="inputAttributes.return_date.label"
                />
                <InputError :message="form.errors.email" class="mt-2" />

            </div>

            <!-- Passengers -->
            <div class="flex col-span-3 sm:col-span-3">
                <i class="material-icons prefix mr-1 relative top-3 text-2xl">hail</i>
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
                <InputError :message="form.errors.email" class="mt-2" />

            </div>

            <!-- Cabin class -->
            <div class="flex col-span-3 sm:col-span-3">
                <i class="material-icons prefix mr-1 relative top-3 text-2xl">airline_seat_recline_extra</i>
                <MaterialUiSelect
                    :id="inputAttributes.cabin_class.id"
                    v-model="form.cabin_class"
                    class="mt-1 block w-full"
                    :customClasses="inputAttributes.cabin_class.customClasses"
                    :label="inputAttributes.cabin_class.label"
                    :optionType="cabinClasses"
                />
                <InputError :message="form.errors.email" class="mt-2" />

            </div>

        </template>

        <template #actions>
            <PrimaryButton :class="{ 'opacity-25': form.processing }"
                           :disabled="form.processing"
                           @click="send()">
                Search flights
            </PrimaryButton>
        </template>
    </FormTemplate>
</template>
