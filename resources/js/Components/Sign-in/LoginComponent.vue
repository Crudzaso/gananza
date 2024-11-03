<template>
    <div class="d-flex flex-column flex-root">
        <!--begin::Page bg image-->
        <!--end::Page bg image-->
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Aside-->
            <div class="d-flex flex-lg-row-fluid">
                <!--begin::Content-->
                <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                    <!--begin::Image-->
                    <img class="theme-light-show mx-auto mw-100 mb-10 mb-lg-20" src="assets/media/auth/Login-image.svg"
                        alt="" style="width: 400px; max-width: 800px;" />
                    <img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                        src="assets/media/auth/agency-dark.png" alt="" />
                    <!--end::Image-->
                    <!--begin::Title-->
                    <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">¡Más cerca de ganar!</h1>
                    <!--end::Title-->
                    <!--begin::Text-->
                    <div class="text-gray-600 fs-base text-center fw-semibold">
                        Participa en rifas emocionantes y gana premios increíbles.
                        <br />Regístrate ahora y no te pierdas la oportunidad de ser el próximo afortunado.
                        <br />¡Cada número cuenta!
                    </div>
                    <!--end::Text-->
                </div>

                <!--end::Content-->
            </div>
            <!--begin::Aside-->
            <!--begin::Body-->
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
                <!--begin::Wrapper-->
                <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                    <!--begin::Content-->
                    <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                            <!--begin::Form-->
                            <form class="form w-100" id="kt_sign_in_form" @submit.prevent="submit">
                                <!--begin::Heading-->
                                <div class="text-center mb-11">
                                    <h1 class="text-gray-900 fw-bolder mb-3 sign-in-title">Iniciar Sesión</h1>
                                    <div class="text-gray-500 fw-semibold fs-6">Tus Campañas Sociales</div>
                                </div>
                                <!--end::Heading-->

                                <!--begin::Login options-->
                                <div class="row g-3 mb-9">
                                    <div class="col-md-6">
                                        <a href="#" @click.prevent="loginWithGoogle"
                                            class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                            <img alt="Icono de Google"
                                                src="assets/media/svg/brand-logos/google-icon.svg"
                                                class="h-15px me-3" />
                                            Google
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="#" @click.prevent="loginWithGitHub"
                                            class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                            <img alt="Icono de GitHub" src="assets/media/svg/brand-logos/github-1.svg"
                                                class="theme-light-show h-15px me-3" />
                                            <img alt="Icono de GitHub Oscuro"
                                                src="assets/media/svg/brand-logos/github-icon.svg"
                                                class="theme-dark-show h-15px me-3" />
                                            GitHub
                                        </a>
                                    </div>
                                </div>
                                <!--end::Login options-->

                                <!--begin::Separator-->
                                <div class="separator separator-content my-14">
                                    <span class="w-125px text-gray-500 fw-semibold fs-7">O con tu correo</span>
                                </div>
                                <!--end::Separator-->

                                <!--begin::Input group-->
                                <div class="fv-row mb-8">
                                    <input type="email" placeholder="Correo Electrónico" name="email"
                                        v-model="form.email" required
                                        class="form-control bg-transparent custom-input" />
                                </div>
                                <div class="fv-row mb-3">
                                    <input type="password" placeholder="Contraseña" name="password"
                                        v-model="form.password" required
                                        class="form-control bg-transparent custom-input" />
                                </div>
                                <!--end::Input group-->

                                <!--begin::Wrapper-->
                                <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                    <div></div>
                                    <a href="authentication/layouts/overlay/reset-password.html"
                                        class="link-primary">¿Olvidaste tu contraseña?</a>
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Submit button-->
                                <div class="d-grid mb-10">
                                    <button type="submit" id="kt_sign_in_submit" class="btn btn-primary"
                                        :disabled="form.processing">
                                        <span v-if="!form.processing" class="indicator-label">Iniciar Sesión</span>
                                        <span v-else class="indicator-progress">Por favor espera...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                </div>
                                <!--end::Submit button-->

                                <!--begin::Sign up-->
                                <div class="text-gray-500 text-center fw-semibold fs-6">¿No tienes cuenta aún?
                                    <a href="register" class="link-primary">Regístrate</a>
                                </div>
                                <!--end::Sign up-->
                            </form>


                            <!--end::Form-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Footer-->
                        <div class="d-flex flex-stack">
                            <!--begin::Languages-->
                            <div class="me-10">
                                <!--begin::Toggle-->
                                <button
                                    class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start"
                                    data-kt-menu-offset="0px, 0px">
                                    <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3"
                                        src="assets/media/flags/spain.svg" alt="" />
                                    <span data-kt-element="current-lang-name" class="me-1">Español</span>
                                    <i class="ki-duotone ki-down fs-5 text-muted rotate-180 m-0"></i>
                                </button>
                                <!--end::Toggle-->
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7"
                                    data-kt-menu="true" id="kt_auth_lang_menu">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link d-flex px-5" data-kt-lang="English">
                                            <span class="symbol symbol-20px me-4">
                                                <img data-kt-element="lang-flag" class="rounded-1"
                                                    src="assets/media/flags/spain.svg" alt="" />
                                            </span>
                                            <span data-kt-element="lang-name">English</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link d-flex px-5" data-kt-lang="Spanish">
                                            <span class="symbol symbol-20px me-4">
                                                <img data-kt-element="lang-flag" class="rounded-1"
                                                    src="assets/media/flags/spain.svg" alt="" />
                                            </span>
                                            <span data-kt-element="lang-name">Spanish</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link d-flex px-5" data-kt-lang="German">
                                            <span class="symbol symbol-20px me-4">
                                                <img data-kt-element="lang-flag" class="rounded-1"
                                                    src="assets/media/flags/germany.svg" alt="" />
                                            </span>
                                            <span data-kt-element="lang-name">German</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link d-flex px-5" data-kt-lang="Japanese">
                                            <span class="symbol symbol-20px me-4">
                                                <img data-kt-element="lang-flag" class="rounded-1"
                                                    src="assets/media/flags/japan.svg" alt="" />
                                            </span>
                                            <span data-kt-element="lang-name">Japanese</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link d-flex px-5" data-kt-lang="French">
                                            <span class="symbol symbol-20px me-4">
                                                <img data-kt-element="lang-flag" class="rounded-1"
                                                    src="assets/media/flags/france.svg" alt="" />
                                            </span>
                                            <span data-kt-element="lang-name">French</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                            </div>
                            <!--end::Languages-->
                            <!--begin::Links-->
                            <div class="d-flex fw-semibold text-primary fs-base gap-5">
                                <a href="TermsOfService" target="_blank">Terminos</a>
                                <a href="PrivacyPolicy" target="_blank">Planes</a>
                                <a href="ContactUs" target="_blank">Contactanos</a>
                            </div>
                            <!--end::Links-->
                        </div>
                        <!--end::Footer-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
</template>

<script>
import { useForm } from '@inertiajs/vue3';

var defaultThemeMode = "light";
var themeMode;
if (document.documentElement) {
    if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
        themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
    } else {
        if (localStorage.getItem("data-bs-theme") !== null) {
            themeMode = localStorage.getItem("data-bs-theme");
        } else {
            themeMode = defaultThemeMode;
        }
    }
    if (themeMode === "system") {
        themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
    }
    document.documentElement.setAttribute("data-bs-theme", themeMode);
}

export default {
    data() {
        return {
            form: useForm({
                email: '',
                password: '',
            }),
        };
    },
    methods: {
        submit() {
            this.form.post(route('login'), {
                onFinish: () => this.form.reset('password'),
            });
        },
        loginWithGoogle() {
            window.location.href = route('google.login');
        },
        loginWithGitHub() {
            window.location.href = route('github.login');
        },
    },
};
</script>


<style scoped>
/* Mejora el estilo del formulario */
.form {
    padding: 2rem;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.sign-in-title {
    font-size: 2rem;
    /* Tamaño de fuente más grande */
    color: #4a76e1;
    /* Color azul */
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    /* Sombra de texto */
}

.btn-primary {
    background-color: #4a76e1;
    border-color: #4a76e1;
}

.btn-primary:hover {
    background-color: #3a61c4;
    border-color: #3a61c4;
}

.separator-content {
    font-weight: 500;
    color: #aaa;
}

.link-primary {
    color: #4a76e1;
}

.link-primary:hover {
    text-decoration: underline;
    color: #3a61c4;
}

.custom-input {
    height: 50px;
    /* Altura del input */
    border-radius: 8px;
    /* Bordes redondeados */
    border: 1px solid #ccc;
    /* Borde suave */
    padding: 0 15px;
    /* Espaciado interno */
    font-size: 1.1rem;
    /* Aumentar el tamaño de la fuente */
    color: #333;
    /* Color del texto */
}

.custom-input::placeholder {
    color: #aaa;
    /* Color del placeholder */
}
</style>
