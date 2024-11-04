<template>
    <div :style="{ background: theme.background }" class="d-flex flex-column flex-root transition-colors duration-500">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-lg-row-fluid">
                <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                    <img v-if="!isDarkMode" class="mx-auto mw-100 mb-10 mb-lg-20" :src="agencyImage"
                        alt="Reset Password" style="width: 400px; max-width: 800px;" />
                    <img v-else class="mx-auto mw-100 mb-10 mb-lg-20" :src="agencyDarkImage" alt="Reset Password"
                        style="width: 400px; max-width: 800px;" />
                    <h1 :style="{ color: theme.textPrimary }" class="fs-2qx fw-bold text-center mb-7">Restablecer
                        Contraseña</h1>
                    <div :style="{ color: theme.textSecondary }" class="fs-base text-center fw-semibold mb-5">
                        Ingresa tu nueva contraseña a continuación.
                        <br />Asegúrate de confirmar tu nueva contraseña.
                    </div>
                </div>
            </div>
            <div :style="{ background: theme.cardBackground }"
                class="d-flex flex-column-fluid justify-content-center p-12">

                <!-- Botón flotante para alternar tema -->
                <button @click="toggleDarkMode"
                    class="theme-toggle-btn p-2 rounded-full transition-transform duration-200 hover:scale-105"
                    :style="{ background: theme.cardBackground }">
                    <component :is="isDarkMode ? 'Sun' : 'Moon'" :size="24"
                        :color="isDarkMode ? theme.emphasis : theme.primary" />
                </button>

                <!-- Contenedor del formulario -->
                <div class="form-container d-flex flex-column align-items-center"
                    style="max-width: 500px; margin: 0 auto;">
                    <form class="form w-100" @submit.prevent="submit"
                        :style="{ background: theme.cardBackground, color: theme.textPrimary, borderColor: theme.border }">
                        <div class="text-center mb-11">
                            <h1 :style="{ color: theme.textPrimary }" class="fw-bolder mb-3 recovery-title">
                                Restablecer Contraseña</h1>
                        </div>

                        <!-- Campos de entrada -->
                        <div class="fv-row mb-4">
                            <input type="email" placeholder="Correo Electrónico" name="email" v-model="form.email"
                                required class="form-control custom-input"
                                :style="{ background: theme.background, color: theme.textPrimary, borderColor: theme.border }" />
                        </div>
                        <div class="fv-row mb-4">
                            <input type="password" placeholder="Nueva Contraseña" name="password"
                                v-model="form.password" required class="form-control custom-input"
                                :style="{ background: theme.background, color: theme.textPrimary, borderColor: theme.border }" />
                        </div>
                        <div class="fv-row mb-4">
                            <input type="password" placeholder="Confirmar Contraseña" name="password_confirmation"
                                v-model="form.password_confirmation" required class="form-control custom-input"
                                :style="{ background: theme.background, color: theme.textPrimary, borderColor: theme.border }" />
                        </div>

                        <!-- Botón de cancelación y envío -->
                        <div class="d-grid mb-10">
                            <button type="button" class="btn btn-secondary" @click="cancel"
                                style="margin-bottom: 10px;">
                                Cancelar
                            </button>
                            <button type="submit" id="kt_reset_password_submit" class="btn"
                                :style="{ background: theme.primary, color: '#fff' }" :disabled="form.processing">
                                <span v-if="!form.processing" class="indicator-label">Restablecer Contraseña</span>
                                <span v-else class="indicator-progress">Por favor espera...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import { Sun, Moon } from 'lucide-vue-next';
import { useForm } from '@inertiajs/vue3';

// Importa las imágenes
import agencyImage from '../../../../public/assets/media/auth/agency.png';
import agencyDarkImage from '../../../../public/assets/media/auth/agency-dark.png';

export default {
    components: {
        Sun,
        Moon,
    },
    setup() {
        const form = useForm({
            email: '',
            password: '',
            password_confirmation: '',
        });

        const isDarkMode = ref(false);

        // Cargar el valor de localStorage al iniciar el componente
        onMounted(() => {
            const savedMode = localStorage.getItem('isDarkMode');
            isDarkMode.value = savedMode === 'true';
        });

        // Cambiar el modo oscuro y guardarlo en localStorage
        const toggleDarkMode = () => {
            isDarkMode.value = !isDarkMode.value;
            localStorage.setItem('isDarkMode', isDarkMode.value);
        };

        const theme = computed(() => ({
            primary: isDarkMode.value ? '#42A5F5' : '#1565C0',
            secondary: isDarkMode.value ? '#26C6DA' : '#00A9A5',
            emphasis: isDarkMode.value ? '#FFCA28' : '#FFC107',
            textPrimary: isDarkMode.value ? '#E0E0E0' : '#212121',
            textSecondary: isDarkMode.value ? '#B0BEC5' : '#757575',
            background: isDarkMode.value ? '#121212' : '#F9FAFB',
            cardBackground: isDarkMode.value ? '#1E1E1E' : '#FFFFFF',
            border: isDarkMode.value ? '#424242' : '#E0E0E0',
        }));

        const submit = () => {
            form.post(route('password.update'), {
                onFinish: () => form.reset('password', 'password_confirmation'),
            });
        };

        // Método para cancelar y redirigir a la página de bienvenida
        const cancel = () => {
            window.location.href = '/'; // Cambia esto según tu ruta real
        };

        return {
            form,
            isDarkMode,
            theme,
            submit,
            toggleDarkMode,
            cancel,
            agencyImage,
            agencyDarkImage,
        };
    }
};
</script>

<style scoped>
/* Personalización de elementos del formulario */
.form {
    padding: 8.35rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.form-container {
    max-width: 700px;
    width: 100%;
    margin: 0 auto;
}

.recovery-title {
    font-size: 2rem;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

/* Ajusta el ancho de los inputs */
.custom-input {
    width: 100%;
    height: 50px;
    border-radius: 8px;
    padding: 0 15px;
    font-size: 1.1rem;
}

.custom-input::placeholder {
    color: #aaa;
}

/* Botón flotante para cambio de tema */
.theme-toggle-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 10;
    border: none;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}
</style>
