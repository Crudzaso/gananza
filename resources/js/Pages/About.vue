<template>
  <div :style="{ backgroundColor: theme.background, color: theme.textPrimary }"
    class="min-h-screen transition-colors duration-500">
    <!-- Encabezado de la página -->
    <header :style="{ background: theme.gradient }" class="p-6 border-b text-center relative">
      <h1 class="text-4xl font-bold mb-2" :style="{ color: theme.textPrimary }">Acerca de Gananza</h1>
      <p class="text-lg">Más cerca de ganar</p>

      <a href="/" class="absolute left-8 top-9">
        <img :src="isDarkMode ? '/assets/media/auth/Logo-Gananza1.svg' : '/assets/media/auth/Logo-Gananza2.svg'"
          alt="Gananza Logo" class="h-12" />
      </a>
    </header>

    <!-- Descripción del proyecto -->
    <section class="py-12 px-6 max-w-4xl mx-auto text-center">
      <h2 class="text-3xl font-semibold mb-4" :style="{ color: theme.accent }">¿Qué es Gananza?</h2>
      <p class="text-lg leading-relaxed" :style="{ color: theme.textSecondary }">
        Gananza es una plataforma innovadora que revoluciona la forma en que organizamos y participamos en rifas,
        conectando personas y sueños a través de la tecnología.
      </p>
      <p class="text-lg leading-relaxed mt-4" :style="{ color: theme.textSecondary }">
        Con valores de confianza, transparencia, innovación y accesibilidad, Gananza ofrece una experiencia única, donde
        cada ticket representa una oportunidad de ganar y hacer realidad tus sueños.
      </p>
    </section>

    <!-- Sección de Equipo -->
    <section class="py-12 px-6 max-w-6xl mx-auto text-center">
      <h2 class="text-3xl font-semibold mb-8" :style="{ color: theme.accent }">Nuestro Equipo</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div v-for="(member, index) in teamMembers" :key="index"
          class="text-center p-6 rounded-lg shadow-lg transition-transform duration-300 hover:scale-105"
          :style="{ background: theme.cardBackground, borderColor: theme.border }">
          <img :src="member.photo" :alt="`Foto de ${member.name}`"
            class="w-40 h-40 mx-auto rounded-full mb-4 object-cover" />
          <h3 class="text-2xl font-semibold" :style="{ color: theme.textPrimary }">{{ member.name }}</h3>
          <p class="text-lg" :style="{ color: theme.textSecondary }">{{ member.role }}</p>
          <p class="mt-2" :style="{ color: theme.textSecondary }">{{ member.bio }}</p>
        </div>
      </div>
    </section>

    <!-- Toggle de Modo Oscuro/Claro -->
    <div class="fixed top-9 right-4">
      <button @click="toggleDarkMode" class="p-3 rounded-full transition-colors duration-200 hover:scale-105"
        :style="{ background: theme.cardBackground }">
        <Sun v-if="isDarkMode" :size="24" :color="theme.accent" />
        <Moon v-else :size="24" :color="theme.primary" />
      </button>
    </div>
  </div>
</template>


<script setup>
import { ref, computed, onMounted } from 'vue';
import { Sun, Moon } from 'lucide-vue-next';

// Estado de modo oscuro
const isDarkMode = ref(false);

// Definición del tema
const themes = {
  light: {
    background: '#F9FAFB',
    textPrimary: '#212121',
    textSecondary: '#757575',
    primary: '#1565C0',
    accent: '#FFC107',
    cardBackground: '#FFFFFF',
    border: '#E0E0E0',
    gradient: 'linear-gradient(135deg, #FFFFFF 0%, #F5F5F5 100%)'
  },
  dark: {
    background: '#121212',
    textPrimary: '#E0E0E0',
    textSecondary: '#B0BEC5',
    primary: '#42A5F5',
    accent: '#FFCA28',
    cardBackground: '#1E1E1E',
    border: '#424242',
    gradient: 'linear-gradient(135deg, #1E1E1E 0%, #2A2A2A 100%)'
  }
};
const theme = computed(() => (isDarkMode.value ? themes.dark : themes.light));

// Función para alternar el modo oscuro/claro
const toggleDarkMode = () => {
  isDarkMode.value = !isDarkMode.value;
  localStorage.setItem('isDarkMode', isDarkMode.value); // Guardar el modo en localStorage
};

// Cargar el modo al montar
onMounted(() => {
  const savedMode = localStorage.getItem('isDarkMode');
  isDarkMode.value = savedMode === 'true';
});

// Información del equipo
const teamMembers = [
  {
    name: 'Alejandro Velasquez',
    role: 'Full Stack Developer',
    bio: 'Como desarrollador tanto de backend como de frontend y Scrum Master, se encarga de liderar las sprints y coordinar al equipo para asegurar que cada fase del desarrollo esté alineada con los objetivos del proyecto',
    photo: '/assets/team/member1.jpg'
  },
  {
    name: 'Diego Andres Ramirez',
    role: 'Full Stack Developer',
    bio: 'Como desarrollador full stack y encargado de la administración de GitHub, su rol es crucial para mantener la coherencia y la calidad del código. Gracias a su dominio en backend y frontend, es capaz de abordar cualquier problema técnico de manera integral, garantizando que los desarrollos sean consistentes y escalables',
    photo: '/assets/team/member2.jpeg'
  },
  {
    name: 'Jafet Ibarguen',
    role: 'Full Stack Developer',
    bio: 'Especializado en el diseño de componentes y en la experiencia de usuario, su trabajo se centra en crear interfaces intuitivas y atractivas para los usuarios de la plataforma de rifas.',
    photo: '/assets/team/member3.jpeg'
  }
];
</script>