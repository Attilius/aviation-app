<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '../../Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '../../Components/AuthenticationCardLogo.vue';
import InputError from '../../Components/InputError.vue';
import PrimaryButton from '../../Components/PrimaryButton.vue';
import MaterialUiInput from '../../Components/MaterialUiInput.vue';
import InputAttributesBuilder from '../../Utils/InputAttributesBuilder.js';

defineProps({
    status: String,
});

const builder = new InputAttributesBuilder('forgotPassword').build();

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <Head>
        <title>Forgot Password</title>
    </Head>

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div class="mb-6 text-sm text-whitesmoke ">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
        </div>

        <div v-if="status" class="mb-6 font-medium text-sm text-success text-center">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div class="w-full border-b-2 pb-0.25">
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

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Email Password Reset Link
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
