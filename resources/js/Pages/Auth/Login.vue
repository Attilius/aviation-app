<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '../../Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '../../Components/AuthenticationCardLogo.vue';
import Checkbox from '../../Components/Checkbox.vue';
import InputError from '../../Components/InputError.vue';
import PrimaryButton from '../../Components/PrimaryButton.vue';
import MaterialUiInput from '../../Components/MaterialUiInput.vue';
import InputAttributesBuilder from '../../Utils/InputAttributesBuilder.js';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: import.meta.env.VITE_DEMO_USER_EMAIL,
    password: import.meta.env.VITE_DEMO_USER_PASSWORD,
    remember: false,
});

const builder = new InputAttributesBuilder('login').build();

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head>
        <title>Login</title>
    </Head>

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div v-if="status" class="mb-4 font-medium text-sm text-success text-center">
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

            <div class="mt-6 w-full border-b-2 pb-0.25">
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

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.remember" name="remember" />
                    <span class="ml-2 text-sm text-whitesmoke">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword"
                      :href="route('password.request')"
                      class="underline text-sm text-whitesmoke hover:text-lightskyblue">
                    Forgot your password?
                </Link>

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Login
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
