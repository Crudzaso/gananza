<template>
    <div :style="{ background: theme.background }" class="d-flex flex-column flex-root transition-colors duration-500">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-lg-row-fluid">
                <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                    <img v-if="!isDarkMode" class="mx-auto mw-100 mb-10 mb-lg-20" src="assets/media/auth/Login-Page.svg"
                        alt="" style="width: 500px; max-width: 800px;" />
                    <img v-else class="mx-auto mw-100 mb-10 mb-lg-20" src="assets/media/auth/Login-Page.svg" alt=""
                        style="width: 500px; max-width: 800px;" />
                    <h1 :style="{ color: theme.textPrimary }" class="fs-2qx fw-bold text-center mb-7">¡Más cerca de
                        ganar!</h1>
                    <div :style="{ color: theme.textSecondary }" class="fs-base text-center fw-semibold">
                        Participa en rifas emocionantes y gana premios increíbles.
                        <br />Regístrate ahora y no te pierdas la oportunidad de ser el próximo afortunado.
                        <br />¡Cada número cuenta!
                    </div>
                </div>
            </div>
            <div :style="{ background: theme.cardBackground }"
                class="d-flex flex-column-fluid justify-content-center p-12">
                <button @click="toggleDarkMode"
                    class="theme-toggle-btn p-2 rounded-full transition-transform duration-200 hover:scale-105"
                    :style="{ background: theme.cardBackground }">
                    <component :is="isDarkMode ? 'Sun' : 'Moon'" :size="24"
                        :color="isDarkMode ? theme.emphasis : theme.primary" />
                </button>

                <div class="form-container d-flex flex-column align-items-center"
                    style="max-width: 500px; margin: 0 auto;">
                    <form class="form w-100" id="kt_sign_in_form" @submit.prevent="submit"
                        :style="{ background: theme.cardBackground, color: theme.textPrimary, borderColor: theme.border }">
                        <div class="text-center mb-11">
                            <h1 :style="{ color: theme.textPrimary }" class="fw-bolder mb-3 sign-in-title">Iniciar
                                Sesión</h1>
                            <div :style="{ color: theme.textSecondary }" class="fw-semibold fs-6">Tus Campañas Sociales
                            </div>
                        </div>

                        <!-- Opciones de inicio de sesión -->
                        <div class="row g-3 mb-9">
                            <div class="col-md-6">
                                <a href="#" @click.prevent="loginWithGoogle" class="btn btn-flex btn-outline w-100"
                                    :style="{ background: theme.cardBackground, color: theme.textPrimary, borderColor: theme.border }">
                                    <img alt="Google" src="assets/media/svg/brand-logos/google-icon.svg"
                                        class="h-15px me-3" />Google
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="#" @click.prevent="loginWithGitHub" class="btn btn-flex btn-outline w-100"
                                    :style="{ background: theme.cardBackground, color: theme.textPrimary, borderColor: theme.border }">
                                    <img alt="GitHub" src="assets/media/svg/brand-logos/github-1.svg"
                                        class="theme-light-show h-15px me-3" />
                                    <img alt="GitHub Dark" src="assets/media/svg/brand-logos/github-icon.svg"
                                        class="theme-dark-show h-15px me-3" />GitHub
                                </a>
                            </div>
                        </div>

                        <!-- Separador -->
                        <div class="separator separator-content my-14" :style="{ color: theme.textSecondary }">
                            <span>O con tu correo</span>
                        </div>

                        <!-- Campos de entrada con errores -->
                        <div class="fv-row mb-8">
                            <input type="email" placeholder="Correo Electrónico" name="email" v-model="form.email"
                                required class="form-control custom-input"
                                :style="{ background: theme.background, color: theme.textPrimary, borderColor: theme.border }" />
                            <InputError :message="form.errors.email" /> <!-- Error de correo electrónico -->
                        </div>

                        <div class="fv-row mb-3">
                            <input type="password" placeholder="Contraseña" name="password" v-model="form.password"
                                required class="form-control custom-input"
                                :style="{ background: theme.background, color: theme.textPrimary, borderColor: theme.border }" />
                            <InputError :message="form.errors.password" /> <!-- Error de contraseña -->
                        </div>

                        <!-- Recordatorio de contraseña -->
                        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                            <a href="/reset-password/some-fake-token" class="link-primary"
                                :style="{ color: theme.primary }">¿Olvidaste tu contraseña?</a>
                        </div>

                        <!-- Botón de envío -->
                        <div class="d-grid mb-10">
                            <button type="button" class="btn btn-secondary" @click="cancel"
                                style="margin-bottom: 10px;">Cancelar</button>
                            <button type="submit" id="kt_sign_in_submit" class="btn"
                                :style="{ background: theme.primary, color: '#fff' }" :disabled="form.processing">
                                <span v-if="!form.processing" class="indicator-label">Iniciar Sesión</span>
                                <span v-else class="indicator-progress">Por favor espera...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>

                        <!-- Registro -->
                        <div :style="{ color: theme.textSecondary }" class="text-center fw-semibold fs-6">¿No tienes
                            cuenta aún?
                            <a href="register" class="link-primary" :style="{ color: theme.primary }">Regístrate</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { ref, computed, onMounted } from 'vue'; // Importar onMounted
import { Sun, Moon } from 'lucide-vue-next';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue'; // Importar InputError


export default {
    components: {
        Sun,
        Moon,
        InputError,
    },
    setup() {
        const form = useForm({
            email: '',
            password: '',
        });

        const isDarkMode = ref(false);

        // Cargar el valor de localStorage al iniciar el componente
        onMounted(() => {
            const savedMode = localStorage.getItem('isDarkMode');
            isDarkMode.value = savedMode === 'true'; // Convertir a booleano
        });

        // Cambiar el modo oscuro y guardarlo en localStorage
        const toggleDarkMode = () => {
            isDarkMode.value = !isDarkMode.value;
            localStorage.setItem('isDarkMode', isDarkMode.value); // Guardar como string
        };

        const theme = computed(() => ({
            primary: isDarkMode.value ? '#42A5F5' : '#1565C0',
            secondary: isDarkMode.value ? '#26C6DA' : '#00A9A5',
            emphasis: isDarkMode.value ? '#FFCA28' : '#FFC107',
            textPrimary: isDarkMode.value ? '#E0E0E0' : '#212121',
            backgroundText: isDarkMode.value ? '#212121' : '#E0E0E0',
            textSecondary: isDarkMode.value ? '#B0BEC5' : '#757575',
            background: isDarkMode.value ? '#121212' : '#F9FAFB',
            cardBackground: isDarkMode.value ? '#1E1E1E' : '#FFFFFF',
            border: isDarkMode.value ? '#424242' : '#E0E0E0',
            success: '#4CAF50',
            gradient: isDarkMode.value
                ? 'linear-gradient(135deg, #1E1E1E 0%, #2A2A2A 100%)'
                : 'linear-gradient(135deg, #FFFFFF 0%, #F5F5F5 100%)'
        }));

        const submit = () => {
            form.post(route('login'), {
                onFinish: () => form.reset('password'),
            });
        };

        const loginWithGoogle = () => {
            window.location.href = route('google.login');
        };

        const loginWithGitHub = () => {
            window.location.href = route('github.login');
        };

        const cancel = () => {
            window.location.href = '/'; // Cambia esto según tu ruta real
        };

        return {
            form,
            isDarkMode,
            theme,
            submit,
            loginWithGoogle,
            loginWithGitHub,
            toggleDarkMode, // Asegúrate de incluir toggleDarkMode en el return
            cancel
        };
    }
};
</script>

<style scoped>
/* Personalización de elementos del formulario */
.form {
    padding: 2.70rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.form-container {
    max-width: 500px;
    width: 100%;
}

.sign-in-title {
    font-size: 2rem;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.custom-input {
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
    position: absolute;
    bottom: 20px;
    right: 20px;
    z-index: 10;
}
</style>
