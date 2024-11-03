<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const loginWithGithub = () => {
    window.location.href = route('github.login');
};

const loginWithGoogle = () => {
    window.location.href = route('google.login');
};
</script>

<template>

    <Head title="Log in" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <!-- Status Message -->
        <div v-if="status" class="mb-6 font-medium text-sm text-green-600 dark:text-green-400">
            {{ status }}
        </div>

        <!-- Social Login Buttons - Moved to top -->
        <div class="grid grid-cols-2 gap-4 mb-8">
            <PrimaryButton @click="loginWithGithub"
                class="flex items-center justify-center gap-2 bg-gray-800 hover:bg-gray-700 text-white transition-all duration-200">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z" />
                </svg>
                <span class="hidden sm:inline">GitHub</span>
            </PrimaryButton>

            <PrimaryButton @click="loginWithGoogle"
                class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 text-white transition-all duration-200">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z" />
                </svg>
                <span class="hidden sm:inline">Google</span>
            </PrimaryButton>
        </div>

        <!-- Divider -->
        <div class="relative my-8">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white dark:bg-gray-800 text-gray-500">O continúa con email</span>
            </div>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <InputLabel for="email" value="Email" class="text-gray-700 dark:text-gray-300" />
                <TextInput id="email" v-model="form.email" type="email"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                    required autofocus autocomplete="username" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="password" value="Password" class="text-gray-700 dark:text-gray-300" />
                <TextInput id="password" v-model="form.password" type="password"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                    required autocomplete="current-password" />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.remember" name="remember"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                </label>

                <Link v-if="canResetPassword" :href="route('password.request')"
                    class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 focus:outline-none focus:underline">
                Forgot your password?
                </Link>
            </div>

            <div>
                <PrimaryButton
                    class="w-full justify-center bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 rounded-lg transition-colors duration-200"
                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>

            <!-- Nuevo enlace de registro -->
            <div class="text-center mt-4">
                <span class="text-sm text-gray-600 dark:text-gray-400">¿No tienes una cuenta? </span>
                <Link :href="route('register')"
                    class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 focus:outline-none focus:underline">
                Regístrate aquí
                </Link>
            </div>
        </form>
    </AuthenticationCard>
</template>