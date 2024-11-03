<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount, computed } from 'vue';
import {
    Sun, Moon, Trophy, ArrowRight,
    Bell, History, Shield, ChevronRight,
    Star
} from 'lucide-vue-next';

// Definición de props
const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});

// Estado del modo oscuro
const isDarkMode = ref(false);
const currentSlide = ref(0);

// Computed para el tema
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

// Datos para la lotería
const lotteryResults = [
    { name: 'Lotería de Medellín', numbers: '1234', date: 'Hoy 8:00 PM', premio_mayor: 100000 },
    { name: 'Lotería de Bogotá', numbers: '5678', date: 'Hoy 9:00 PM', premio_mayor: 50000 },
    { name: 'Lotería del Meta', numbers: '9012', date: 'Mañana 7:00 PM', premio_mayor: 30000 }
];

// Funcionalidades de características
const features = [
    {
        icon: Bell,
        title: 'Notificaciones en tiempo real',
        description: 'Recibe alertas instantáneas sobre tus rifas favoritas'
    },
    {
        icon: History,
        title: 'Historial completo',
        description: 'Accede a tu historial de participaciones y ganancias'
    },
    {
        icon: Shield,
        title: 'Seguridad garantizada',
        description: 'Transacciones seguras y reguladas'
    }
];

// Testimonios
const testimonials = [
    { name: 'Juan P.', text: 'Gané mi primer iPhone gracias a Gananza. ¡Increíble!', rating: 5 },
    { name: 'María A.', text: 'La plataforma más confiable para rifas que he usado.', rating: 5 },
    { name: 'Carlos R.', text: 'Super fácil de usar y los premios son reales.', rating: 5 }
];

// Intervalo para el carrusel de testimonios
let slideInterval;

// Cargar el estado de localStorage al iniciar el componente
onMounted(() => {
    const savedMode = localStorage.getItem('isDarkMode');
    isDarkMode.value = savedMode === 'true'; // Convertir a booleano

    slideInterval = setInterval(() => {
        currentSlide.value = (currentSlide.value + 1) % testimonials.length;
    }, 5000);
});

// Cambiar el modo oscuro y guardarlo en localStorage
const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;
    localStorage.setItem('isDarkMode', isDarkMode.value); // Guardar como string
};

// Limpiar el intervalo al desmontar el componente
onBeforeUnmount(() => {
    if (slideInterval) clearInterval(slideInterval);
});
</script>

<template>

    <Head title="Welcome" />

    <div :style="{ background: theme.background }" class="min-h-screen transition-colors duration-500">
        <!-- Header -->
        <header :style="{ background: theme.gradient }" class="p-6 border-b">
            <div class="max-w-6xl mx-auto flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <Trophy :size="32" :style="{ color: theme.emphasis }" />
                    <h1 :style="{ color: theme.textPrimary }" class="text-2xl font-bold">
                        Gananza
                    </h1>
                </div>

                <div class="flex items-center gap-4">
                    <Link v-if="canLogin && !$page.props.auth.user" :href="route('login')"
                        class="px-4 py-2 rounded-lg hover:bg-opacity-90 transition-transform duration-200 hover:scale-105"
                        :style="{ color: theme.textPrimary, background: theme.backgroundText }">
                    Iniciar Sesión
                    </Link>

                    <Link v-if="canRegister && !$page.props.auth.user" :href="route('register')"
                        class="px-4 py-2 rounded-lg text-white hover:bg-opacity-90 transition-transform duration-200 hover:scale-105"
                        :style="{ background: theme.primary }">
                    Registrarse
                    </Link>

                    <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                        class="px-4 py-2 rounded-lg text-white hover:bg-opacity-90 transition-transform duration-200 hover:scale-105"
                        :style="{ background: theme.primary }">
                    Dashboard
                    </Link>

                    <button @click="toggleDarkMode"
                        class="p-2 rounded-full transition-transform duration-200 hover:scale-105"
                        :style="{ background: theme.cardBackground }">
                        <Sun v-if="isDarkMode" :size="24" :color="theme.emphasis" />
                        <Moon v-else :size="24" :color="theme.primary" />
                    </button>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="py-16 px-6">
            <div class="max-w-6xl mx-auto">
                <div class="text-center space-y-6">
                    <h2 :style="{ color: theme.textPrimary }" class="text-5xl font-bold tracking-tight">
                        Más cerca de ganar
                    </h2>
                    <p :style="{ color: theme.textSecondary }" class="text-xl max-w-2xl mx-auto">
                        Explora rifas en tiempo real y elige la tuya para ganar en grande.
                    </p>
                    <button :style="{ background: theme.primary }"
                        class="px-8 py-3 rounded-lg text-white text-lg font-medium shadow-lg inline-flex items-center gap-2 transition-transform duration-200 hover:scale-105">
                        <a href="register">¡Empieza a jugar y gana!</a>
                        <ArrowRight :size="20" />
                    </button>
                </div>
            </div>
        </section>

        <!-- Live Results Section -->
        <section :style="{ background: theme.gradient }" class="py-12 px-6">
            <div class="max-w-6xl mx-auto text-center space-y-6 ">
                <div class="text-center mb-8">
                    <h3 :style="{ color: theme.textPrimary }" class="text-2xl font-bold mb-2">
                        Resultados en Vivo
                    </h3>
                    <p :style="{ color: theme.textSecondary }">
                        Últimos resultados de loterías en Antioquia
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div v-for="(result, index) in lotteryResults" :key="index"
                        :style="{ background: theme.cardBackground }"
                        class="p-6 rounded-xl shadow-lg transform transition-all duration-300 hover:scale-105">
                        <h4 :style="{ color: theme.textPrimary }" class="font-semibold mb-2">
                            {{ result.name }}
                        </h4>
                        <div :style="{ color: theme.emphasis }" class="text-3xl font-bold mb-2">
                            {{ result.numbers }}
                        </div>
                        <p :style="{ color: theme.textSecondary }">
                            {{ result.date }}
                        </p>
                        <p :style="{ color: theme.emphasis }" class="text-4xl font-bold mb-2">
                            {{ result.premio_mayor }}
                        </p>
                    </div>
                </div>
                <button :style="{ background: theme.primary }"
                    class="px-8 py-3 rounded-lg text-white text-lg font-medium shadow-lg inline-flex items-center gap-2 transition-transform duration-200 hover:scale-105">
                    ¡Ver resultados!
                    <ArrowRight :size="20" />
                </button>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-16 px-6">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <h3 :style="{ color: theme.textPrimary }" class="text-2xl font-bold mb-2">
                        ¿Por qué registrarse en Gananza?
                    </h3>
                    <p :style="{ color: theme.textSecondary }">
                        Descubre todos los beneficios de ser parte de nuestra comunidad
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div v-for="(feature, index) in features" :key="index"
                        class="text-center space-y-4 transform transition-all duration-300 hover:scale-105">
                        <div class="w-16 h-16 rounded-full mx-auto flex items-center justify-center"
                            :style="{ background: `${theme.secondary}15` }">
                            <component :is="feature.icon" :size="32" :style="{ color: theme.secondary }" />
                        </div>
                        <h4 :style="{ color: theme.textPrimary }" class="text-xl font-semibold">
                            {{ feature.title }}
                        </h4>
                        <p :style="{ color: theme.textSecondary }">
                            {{ feature.description }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section :style="{ background: theme.gradient }" class="py-16 px-6">
            <div class="max-w-6xl mx-auto">
                <div class="text-center space-y-8">
                    <h3 :style="{ color: theme.textPrimary }" class="text-2xl font-bold">
                        Lo que dicen nuestros usuarios
                    </h3>
                    <div :style="{ background: theme.cardBackground }"
                        class="max-w-2xl mx-auto p-8 rounded-xl transform transition-all duration-300">
                        <div class="flex justify-center mb-4">
                            <Star v-for="n in testimonials[currentSlide].rating" :key="n" :size="20"
                                :fill="theme.emphasis" :color="theme.emphasis" />
                        </div>
                        <p :style="{ color: theme.textPrimary }" class="text-lg mb-4 italic">
                            "{{ testimonials[currentSlide].text }}"
                        </p>
                        <p :style="{ color: theme.textSecondary }" class="font-medium">
                            {{ testimonials[currentSlide].name }}
                        </p>
                    </div>
                    <div class="flex justify-center gap-2">
                        <button v-for="(_, index) in testimonials" :key="index" @click="currentSlide = index"
                            class="w-2 h-2 rounded-full transition-all duration-300" :style="{
                                background: currentSlide === index ? theme.primary : theme.border,
                                transform: currentSlide === index ? 'scale(1.5)' : 'scale(1)'
                            }" />
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-16 px-6">
            <div class="max-w-6xl mx-auto">
                <div class="text-center space-y-6">
                    <h3 :style="{ color: theme.textPrimary }" class="text-3xl font-bold">
                        ¿Preparado para ganar?
                    </h3>
                    <p :style="{ color: theme.textSecondary }" class="text-xl">
                        Solo te falta un paso: ¡Regístrate en Gananza!
                    </p>
                    <button :style="{ background: theme.primary }"
                        class="px-8 py-3 rounded-lg text-white text-lg font-medium shadow-lg inline-flex items-center gap-2 transition-transform duration-200 hover:scale-105">
                        <a href="register">Crear cuenta gratis</a>
                        <ChevronRight :size="20" />
                    </button>
                </div>
            </div>
        </section>

        <footer class="py-8 bg-gray-100 text-center"
            :style="{ background: theme.cardBackground, color: theme.textSecondary }">
            <div class="max-w-6xl mx-auto space-y-4">
                <div class="flex justify-center space-x-8">
                    <Link href="/terms" class="hover:underline transition-colors duration-200"
                        :style="{ color: theme.textSecondary }">Términos y Condiciones</Link>
                    <Link href="/privacy" class="hover:underline transition-colors duration-200"
                        :style="{ color: theme.textSecondary }">Política de Privacidad</Link>
                    <Link href="https://github.com/tu-repositorio" target="_blank"
                        class="hover:underline transition-colors duration-200" :style="{ color: theme.textSecondary }">
                    Repositorio en GitHub</Link>
                    <Link href="/contact" class="hover:underline transition-colors duration-200"
                        :style="{ color: theme.textSecondary }">Contáctanos</Link>
                    <Link href="/about" class="hover:underline transition-colors duration-200"
                        :style="{ color: theme.textSecondary }">Sobre Nosotros</Link>
                </div>
                <p class="text-sm mt-4">Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})</p>
            </div>
        </footer>
    </div>
</template>