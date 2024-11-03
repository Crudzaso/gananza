<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    email: '',
    lastname: '',
    password: '',
    document: '',
    document_type: '',
    phone_number: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Crear cuenta</h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Por favor completa tus datos para registrarte</p>
        </div>

        <form @submit.prevent="submit" class="space-y-4">
            <!-- Grid para nombre y apellido -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <InputLabel for="name" value="Nombre" class="text-gray-700 dark:text-gray-300" />
                    <TextInput
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <InputError class="mt-1" :message="form.errors.name" />
                </div>

                <div>
                    <InputLabel for="lastname" value="Apellido" class="text-gray-700 dark:text-gray-300" />
                    <TextInput
                        id="lastname"
                        v-model="form.lastname"
                        type="text"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                        required
                        autocomplete="family-name"
                    />
                    <InputError class="mt-1" :message="form.errors.lastname" />
                </div>
            </div>

            <!-- Email -->
            <div>
                <InputLabel for="email" value="Email" class="text-gray-700 dark:text-gray-300" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                    required
                    autocomplete="username"
                />
                <InputError class="mt-1" :message="form.errors.email" />
            </div>

            <!-- Grid para documento y tipo de documento -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <InputLabel for="document_type" value="Tipo de Documento" class="text-gray-700 dark:text-gray-300" />
                    <select
                        id="document_type"
                        v-model="form.document_type"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                        required
                    >
                        <option value="">Seleccionar...</option>
                        <option value="DNI">DNI</option>
                        <option value="Pasaporte">Pasaporte</option>
                        <option value="CE">Carné de Extranjería</option>
                    </select>
                    <InputError class="mt-1" :message="form.errors.document_type" />
                </div>

                <div>
                    <InputLabel for="document" value="Número de Documento" class="text-gray-700 dark:text-gray-300" />
                    <TextInput
                        id="document"
                        v-model="form.document"
                        type="text"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                        required
                    />
                    <InputError class="mt-1" :message="form.errors.document" />
                </div>
            </div>

            <!-- Teléfono -->
            <div>
                <InputLabel for="phone_number" value="Teléfono" class="text-gray-700 dark:text-gray-300" />
                <TextInput
                    id="phone_number"
                    v-model="form.phone_number"
                    type="tel"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                    required
                />
                <InputError class="mt-1" :message="form.errors.phone_number" />
            </div>

            <!-- Grid para contraseñas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <InputLabel for="password" value="Contraseña" class="text-gray-700 dark:text-gray-300" />
                    <TextInput
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-1" :message="form.errors.password" />
                </div>

                <div>
                    <InputLabel for="password_confirmation" value="Confirmar Contraseña" class="text-gray-700 dark:text-gray-300" />
                    <TextInput
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-1" :message="form.errors.password_confirmation" />
                </div>
            </div>

            <!-- Términos y condiciones -->
            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-6">
                <InputLabel for="terms">
                    <div class="flex items-center">
                        <Checkbox id="terms" v-model:checked="form.terms" name="terms" required 
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        <div class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                            Acepto los <a target="_blank" :href="route('terms.show')" 
                                class="text-indigo-600 hover:text-indigo-500 underline">Términos de Servicio</a> y la 
                            <a target="_blank" :href="route('policy.show')" 
                                class="text-indigo-600 hover:text-indigo-500 underline">Política de Privacidad</a>
                        </div>
                    </div>
                    <InputError class="mt-1" :message="form.errors.terms" />
                </InputLabel>
            </div>

            <!-- Botones de acción -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
                <Link :href="route('login')" 
                    class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 underline">
                    ¿Ya tienes una cuenta? Inicia sesión
                </Link>

                <PrimaryButton 
                    class="w-full sm:w-auto justify-center bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200"
                    :class="{ 'opacity-25': form.processing }" 
                    :disabled="form.processing">
                    Registrarse
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>