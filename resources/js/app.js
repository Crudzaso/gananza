import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import '@splidejs/vue-splide/css';


import './bootstrap';
import '../css/app.css';

// Importar estilos de Metronic
import '../../public/assets/plugins/global/plugins.bundle.css';
import '../../public/assets/css/style.bundle.css';

// Importar componentes
import Navbar from './Components/Dashboard/NavBar.vue';
import Footer from './Components/Dashboard/Footer.vue';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const vueApp = createApp({ render: () => h(App, props) });

        // Uso de plugins
        vueApp.use(plugin).use(ZiggyVue);

        // Registrar componentes globalmente
        vueApp.component('Navbar', Navbar);
        vueApp.component('Footer', Footer);

        // Montar la aplicación
        vueApp.mount(el);

        // Inicializar scripts de Metronic después del montaje
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof KTUtil !== 'undefined') {
              KTUtil.init();
            }
            if (typeof KTMenu !== 'undefined') {
              KTMenu.init();
            }
            if (typeof KTDrawer !== 'undefined') {
              KTDrawer.init();
            }
            if (typeof KTIcon !== 'undefined') {
                KTIcon.init();
              }
          });
    },
    progress: {
        color: '#4B5563',
    },
});
