<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '../../Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '../../Components/AuthenticationCardLogo.vue';
import Checkbox from '../../Components/Checkbox.vue';
import InputError from '../../Components/InputError.vue';
import InputLabel from '../../Components/InputLabel.vue';
import PrimaryButton from '../../Components/PrimaryButton.vue';
import MaterialUiInput from '../../Components/MaterialUiInput.vue';
import InputAttributesBuilder from '../../Utils/InputAttributesBuilder.js';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const builder = new InputAttributesBuilder('register').build();

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head>
        <title>Register</title>
    </Head>

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <form @submit.prevent="submit">
            <div>
                <MaterialUiInput
                    :id="builder.full_name.id"
                    v-model="form.name"
                    :type="builder.full_name.type"
                    class="mt-1 block w-full"
                    :customClasses="builder.full_name.customClasses"
                    :label="builder.full_name.label"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-6">
                <MaterialUiInput
                    :id="builder.email.id"
                    v-model="form.email"
                    :type="builder.email.type"
                    class="mt-1 block w-full"
                    :customClasses="builder.email.customClasses"
                    :label="builder.email.label"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-6">
                <MaterialUiInput
                    :id="builder.password.id"
                    v-model="form.password"
                    :type="builder.password.type"
                    class="mt-1 block w-full"
                    :customClasses="builder.password.customClasses"
                    :label="builder.password.label"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-6">
                <MaterialUiInput
                    :id="builder.password_confirmation.id"
                    v-model="form.password_confirmation"
                    :type="builder.password_confirmation.type"
                    class="mt-1 block w-full"
                    :customClasses="builder.password_confirmation.customClasses"
                    :label="builder.password_confirmation.label"
                />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                <InputLabel for="terms">
                    <div class="flex items-center">
                        <Checkbox id="terms" v-model:checked="form.terms" name="terms" required />

                        <div class="ml-2">
                            I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Privacy Policy</a>
                        </div>
                    </div>
                    <InputError class="mt-2" :message="form.errors.terms" />
                </InputLabel>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="underline text-sm text-whitesmoke hover:text-lightskyblue">
                    Already registered?
                </Link>

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
