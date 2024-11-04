<template>
    <div :style="{ background: theme.background }" class="d-flex flex-column flex-root transition-colors duration-500">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!-- Formulario de Registro -->
            <div :style="{ background: theme.cardBackground }"
                class="d-flex flex-column-fluid justify-content-center p-12 w-100 w-lg-50">
                <!-- Botón de cambio de tema -->
                <button @click="toggleDarkMode"
                    class="theme-toggle-btn p-2 rounded-full transition-transform duration-200 hover:scale-105"
                    :style="{ background: theme.cardBackground }">
                    <component :is="isDarkMode ? 'Sun' : 'Moon'" :size="24"
                        :color="isDarkMode ? theme.emphasis : theme.primary" />
                </button>

                <div class="form-container d-flex flex-column align-items-center"
                    style="max-width: 600px; margin: 0 auto;">
                    <form class="form w-100" @submit.prevent="submit"
                        :style="{ background: theme.cardBackground, color: theme.textPrimary, borderColor: theme.border }">
                        <div class="text-center mb-5">
                            <h1 :style="{ color: theme.textPrimary }" class="fw-bolder mb-3 register-title">Registrate
                            </h1>
                            <div :style="{ color: theme.textSecondary }" class="fw-semibold fs-6">Crea una cuenta para
                                acceder a nuestros servicios.</div>
                        </div>

                        <!-- Opciones de Registro con Redes Sociales -->
                        <div class="row g-3 mb-5">
                            <div class="col-md-6">
                                <button @click.prevent="registerWithGoogle" class="btn btn-flex btn-outline w-100"
                                    :style="{ background: theme.cardBackground, color: theme.textPrimary, borderColor: theme.border }">
                                    <img alt="Google" src="assets/media/svg/brand-logos/google-icon.svg"
                                        class="h-15px me-3" />
                                    Google
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button @click.prevent="registerWithApple" class="btn btn-flex btn-outline w-100"
                                    :style="{ background: theme.cardBackground, color: theme.textPrimary, borderColor: theme.border }">
                                    <img alt="Apple" src="assets/media/svg/brand-logos/github-1.svg"
                                        class="theme-light-show h-15px me-3" />
                                    <img alt="Apple Dark" src="assets/media/svg/brand-logos/github-icon.svg"
                                        class="theme-dark-show h-15px me-3" />
                                    GitHub
                                </button>
                            </div>
                        </div>

                        <!-- Separador -->
                        <div class="separator separator-content my-10" :style="{ color: theme.textSecondary }">
                            <span>O usa tu correo</span>
                        </div>

                        <!-- Campos de Registro -->
                        <div class="row g-3">
                            <div class="col-md-6 mb-4">
                                <input type="text" placeholder="Nombre" name="name" v-model="form.name" required
                                    class="form-control custom-input"
                                    :style="{ background: theme.background, color: theme.textPrimary, borderColor: theme.border }" />
                            </div>
                            <div class="col-md-6 mb-4">
                                <input type="text" placeholder="Apellido" name="lastname" v-model="form.lastname"
                                    required class="form-control custom-input"
                                    :style="{ background: theme.background, color: theme.textPrimary, borderColor: theme.border }" />
                            </div>
                            <div class="col-md-6 mb-4">
                                <input type="text" placeholder="Documento" name="document" v-model="form.document"
                                    required class="form-control custom-input"
                                    :style="{ background: theme.background, color: theme.textPrimary, borderColor: theme.border }" />
                            </div>
                            <div class="col-md-6 mb-4">
                                <select name="document_type" v-model="form.document_type" required
                                    class="form-control custom-input"
                                    :style="{ background: theme.background, color: theme.textPrimary, borderColor: theme.border }">
                                    <option value="" disabled selected>Tipo de Documento</option>
                                    <option value="ID">Cédula</option>
                                    <option value="Passport">Pasaporte</option>
                                    <option value="Other">Otro</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <input type="text" placeholder="Teléfono" name="phone_number"
                                    v-model="form.phone_number" required class="form-control custom-input"
                                    :style="{ background: theme.background, color: theme.textPrimary, borderColor: theme.border }" />
                            </div>
                            <div class="col-md-6 mb-4">
                                <input type="email" placeholder="Correo Electrónico" name="email" v-model="form.email"
                                    required class="form-control custom-input"
                                    :style="{ background: theme.background, color: theme.textPrimary, borderColor: theme.border }" />
                            </div>
                            <div class="col-md-6 mb-4">
                                <input type="password" placeholder="Contraseña" name="password" v-model="form.password"
                                    required class="form-control custom-input"
                                    :style="{ background: theme.background, color: theme.textPrimary, borderColor: theme.border }" />
                            </div>
                            <div class="col-md-6 mb-4">
                                <input type="password" placeholder="Confirmar Contraseña" name="confirmPassword"
                                    v-model="form.confirmPassword" required class="form-control custom-input"
                                    :style="{ background: theme.background, color: theme.textPrimary, borderColor: theme.border }" />
                            </div>
                        </div>

                        <!-- Aceptación de Términos -->
                        <div class="fv-row mb-5">
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" v-model="form.termsAccepted" />
                                <span class="form-check-label fw-semibold" :style="{ color: theme.textSecondary }">
                                    Acepto los <a href="#" :style="{ color: theme.primary }">Términos y Condiciones</a>
                                </span>
                            </label>
                        </div>

                        <!-- Botón de Envío -->
                        <div class="d-grid mb-5">
                            <button type="button" class="btn btn-secondary" @click="cancel"
                                style="margin-bottom: 10px;">
                                Cancelar
                            </button>
                            <button type="submit" class="btn" :style="{ background: theme.primary, color: '#fff' }"
                                :disabled="!form.termsAccepted || form.processing">
                                <span v-if="!form.processing" class="indicator-label">Registrarse</span>
                                <span v-else class="indicator-progress">Por favor espera...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>

                        <!-- Enlace a Iniciar Sesión -->
                        <div class="text-center fw-semibold fs-6" :style="{ color: theme.textSecondary }">
                            ¿Ya tienes una cuenta?
                            <a href="/login" class="link-primary" :style="{ color: theme.primary }">Inicia sesión</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="d-none d-lg-flex flex-column flex-center p-10 w-50">
                <img v-if="!isDarkMode" class="mx-auto mw-100 mb-5" src="assets/media/auth/agency.png"
                    alt="Gananza Logo" style="width: 300px; max-width: 500px;" />
                <img v-else class="mx-auto mw-100 mb-5" src="assets/media/auth/agency-dark.png" alt="Gananza Logo"
                    style="width: 300px; max-width: 500px;" />
                <h1 :style="{ color: theme.textPrimary }" class="fs-2qx fw-bold text-center mb-5">¡Descubre Gananza!
                </h1>
                <div :style="{ color: theme.textSecondary }" class="fs-base text-center fw-semibold">
                    Organiza rifas y compra tus boletos para ganar increíbles premios.
                    <br />La fortuna está de tu lado, y cada ticket es una oportunidad para el éxito.
                    <br />¡Únete a nuestra comunidad y comienza a jugar con la suerte a tu favor!
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue'; // Importar onMounted
import { Sun, Moon } from 'lucide-vue-next';
import { useForm } from '@inertiajs/vue3';

export default {
    components: {
        Sun,
        Moon,
    },
    setup() {
        const form = useForm({
            name: '',
            lastname: '',
            document: '',
            document_type: '',
            phone_number: '',
            email: '',
            password: '',
            confirmPassword: '',
            termsAccepted: false,
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
            emphasis: isDarkMode.value ? '#FFCA28' : '#FFC107',
            textPrimary: isDarkMode.value ? '#E0E0E0' : '#212121',
            textSecondary: isDarkMode.value ? '#B0BEC5' : '#757575',
            background: isDarkMode.value ? '#121212' : '#F9FAFB',
            cardBackground: isDarkMode.value ? '#1E1E1E' : '#FFFFFF',
            border: isDarkMode.value ? '#424242' : '#E0E0E0',
        }));

        const submit = () => {
            form.post(route('register'), {
                onFinish: () => form.reset('password', 'confirmPassword'),
            });
        };

        const registerWithGoogle = () => {
            window.location.href = route('google.register');
        };

        const registerWithApple = () => {
            window.location.href = route('apple.register');
        };

        const cancel = () => {
            window.location.href = '/'; // Cambia esto según tu ruta real
        };

        return {
            form,
            isDarkMode,
            theme,
            submit,
            registerWithGoogle,
            registerWithApple,
            toggleDarkMode, // Asegúrate de incluir toggleDarkMode en el return
            cancel
        };
    },
};
</script>

<style scoped>
.form-container {

    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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

.theme-toggle-btn {
    position: absolute;
    bottom: 20px;
    right: 20px;
    z-index: 10;
}

.register-title {
    font-size: 2rem;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}
</style>
