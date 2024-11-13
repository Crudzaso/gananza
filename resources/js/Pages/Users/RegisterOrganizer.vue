<template>
    <div :style="{ background: theme.background }" class="d-flex flex-column flex-root min-h-100vh transition-colors duration-500">
        <div class="d-flex flex-column flex-lg-row  flex-column-fluid min-h-100vh">
            <!-- Formulario de Registro de Organizadores -->
            <div :style="{ background: theme.cardBackground }"
                class="d-flex flex-column-fluid justify-content-center align-items-center p-12 w-100 w-lg-50 min-h-100vh">
                <div class="form-container d-flex flex-column align-items-center" style="max-width: 600px; margin: 0 auto;">
                    <form class="form w-100" @submit.prevent="submit"
                        :style="{ background: theme.cardBackground, color: theme.textPrimary, borderColor: theme.border }">
                        <div class="text-center mb-5">
                            <h1 :style="{ color: theme.textPrimary }" class="fw-bolder mb-3 register-title">Registro de Organizadores</h1>
                            <div :style="{ color: theme.textSecondary }" class="fw-semibold fs-6">
                                Registra tu cuenta de organizador para gestionar eventos.
                            </div>
                        </div>
                        <!-- Campos de Registro -->
                        <div class="row g-3">
                            <div class="col-md-6 mb-4">
                                <input type="text" placeholder="Documento" name="document" v-model="document"
                                    class="form-control custom-input"
                                    :style="{ background: theme.background, color: theme.textPrimary, borderColor: theme.border }" />
                                <InputError :message="errors.document" />
                            </div>

                            <div class="col-md-6 mb-4">
                                <select name="document_type" v-model="document_type" class="form-control custom-input"
                                    :style="{ background: theme.background, color: theme.textPrimary, borderColor: theme.border }">
                                    <option value="" disabled selected>Tipo de Documento</option>
                                    <option value="ID">Cédula</option>
                                    <option value="Passport">Pasaporte</option>
                                    <option value="Other">Otro</option>
                                </select>
                                <InputError :message="errors.document_type" />
                            </div>

                            <div class="col-md-12 mb-4">
                                <input type="file" @change="handleFileUpload" class="form-control custom-input"
                                    :style="{ background: theme.background, color: theme.textPrimary, borderColor: theme.border }" />
                                <InputError :message="errors.document_image" />
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="d-grid mb-5">
                            <button type="button" class="btn btn-secondary" @click="cancel" style="margin-bottom: 10px;">
                                Cancelar
                            </button>
                            <button type="submit" class="btn" :style="{ background: theme.primary, color: '#fff' }"
                                :disabled="loading">
                                <span v-if="!loading">Registrar</span>
                                <span v-else>Enviando...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Imagen y Mensaje -->
            <div class="d-none d-lg-flex flex-column flex-center p-10 w-50 min-h-100vh">
                <img v-if="!isDarkMode" class="mx-auto mw-100 mb-5" src="assets/media/auth/Login-Page.svg" alt="Gananza Logo" />
                <img v-else class="mx-auto mw-100 mb-5" src="assets/media/auth/Login-Page.svg" alt="Gananza Logo" />
                <h1 :style="{ color: theme.textPrimary }" class="fs-2qx fw-bold text-center mb-5">¡Únete como Organizador!</h1>
                <div :style="{ color: theme.textSecondary }" class="fs-base text-center fw-semibold">
                    Comienza a gestionar tus eventos y rifas con nuestra plataforma.
                    <br />Regístrate como organizador y aprovecha todas nuestras herramientas.
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import InputError from '@/Components/InputError.vue';

export default {
    components: {
        InputError,
    },
    setup() {
        const document = ref('');
        const document_type = ref('');
        const document_image = ref(null);
        const errors = ref({});
        const loading = ref(false);

        const isDarkMode = ref(false);

        onMounted(() => {
            const savedMode = localStorage.getItem('isDarkMode');
            isDarkMode.value = savedMode === 'true';
        });

        const theme = computed(() => ({
            primary: isDarkMode.value ? '#42A5F5' : '#1565C0',
            textPrimary: isDarkMode.value ? '#E0E0E0' : '#212121',
            textSecondary: isDarkMode.value ? '#B0BEC5' : '#757575',
            background: isDarkMode.value ? '#121212' : '#F9FAFB',
            cardBackground: isDarkMode.value ? '#1E1E1E' : '#FFFFFF',
            border: isDarkMode.value ? '#424242' : '#E0E0E0',
        }));

        const handleFileUpload = (event) => {
            const file = event.target.files[0];
            document_image.value = file;
        };

        const submit = async () => {
            loading.value = true;
            const formData = new FormData();
            formData.append('document', document.value);
            formData.append('document_type', document_type.value);
            formData.append('document_image', document_image.value);

            try {
                const response = await axios.post(route('organizer.register'), formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });
                window.location.href = '/admin/panel';
            } catch (error) {
                errors.value = error.response?.data?.errors || {};
            } finally {
                loading.value = false;
            }
        };

        const cancel = () => {
            window.location.href = '/dashboard';
        };

        return {
            document,
            document_type,
            document_image,
            errors,
            loading,
            isDarkMode,
            theme,
            handleFileUpload,
            submit,
            cancel,
        };
    },
};
</script>

<style scoped>
.form-container {
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 5rem;
    height: 50vh;
}

.custom-input {
    height: 50px;
    border-radius: 8px;
    padding: 0 15px;
    font-size: 1.1rem;
}

.register-title {
    font-size: 2rem;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.separator {
    margin-top: 20px;
    margin-bottom: 20px;
}

.min-h-100vh {
    min-height: 100vh;
}

@media (max-width: 768px) {
    .form-container {
        padding: 2rem;
    }
}
</style>