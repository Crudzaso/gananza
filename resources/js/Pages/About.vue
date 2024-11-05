<template>
  <div :style="{ backgroundColor: theme.background, color: theme.textPrimary }" class="min-h-screen transition-colors duration-500">
    <!-- Encabezado de la página -->
    <header :style="{ background: theme.primary }" class="p-8 text-center">
      <h1 class="text-4xl font-bold mb-2">Acerca de Gananza</h1>
      <p class="text-lg">Más cerca de ganar</p>
    </header>

    <!-- Descripción del proyecto -->
    <section class="py-12 px-6 max-w-4xl mx-auto text-center">
      <h2 class="text-3xl font-semibold mb-4" :style="{ color: theme.accent }">¿Qué es Gananza?</h2>
      <p class="text-lg leading-relaxed" :style="{ color: theme.textSecondary }">
        Gananza es una plataforma innovadora que revoluciona la forma en que organizamos y participamos en rifas, conectando personas y sueños a través de la tecnología.
      </p>
      <p class="text-lg leading-relaxed mt-4" :style="{ color: theme.textSecondary }">
        Con valores de confianza, transparencia, innovación y accesibilidad, Gananza ofrece una experiencia única, donde cada ticket representa una oportunidad de ganar y hacer realidad tus sueños.
      </p>
    </section>

    <!-- Sección de Equipo -->
    <section class="py-12 px-6 max-w-6xl mx-auto text-center">
      <h2 class="text-3xl font-semibold mb-8" :style="{ color: theme.accent }">Nuestro Equipo</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div v-for="(member, index) in teamMembers" :key="index" class="text-center p-6 rounded-lg shadow-lg transition-transform duration-300 hover:scale-105" :style="{ background: theme.cardBackground }">
          <img :src="member.photo" alt="Foto de {{ member.name }}" class="w-32 h-32 mx-auto rounded-full mb-4" />
          <h3 class="text-2xl font-semibold" :style="{ color: theme.textPrimary }">{{ member.name }}</h3>
          <p class="text-lg" :style="{ color: theme.textSecondary }">{{ member.role }}</p>
          <p class="mt-2" :style="{ color: theme.textSecondary }">{{ member.bio }}</p>
        </div>
      </div>
    </section>

    <!-- Toggle de Modo Oscuro/Claro -->
    <div class="fixed top-4 right-4">
      <button @click="toggleDarkMode" class="p-3 rounded-full transition-colors duration-200 hover:scale-105" :style="{ background: theme.cardBackground }">
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

// Definición del tema dinámico
const theme = computed(() => ({
  background: isDarkMode.value ? '#121212' : '#FFFFFF',
  textPrimary: isDarkMode.value ? '#E0E0E0' : '#2C3E50',
  textSecondary: isDarkMode.value ? '#B0BEC5' : '#757575',
  primary: isDarkMode.value ? '#5DADE2' : '#5DADE2', // Azul suave en ambos modos
  accent: isDarkMode.value ? '#F4D03F' : '#58D68D', // Dorado y Verde Suave
  cardBackground: isDarkMode.value ? '#1E1E1E' : '#FFFFFF'
}));

// Información del equipo
const teamMembers = ref([
  {
    name: 'Desarrollador 1',
    role: 'Backend Developer',
    bio: 'Especializado en desarrollo de backend con amplia experiencia en PHP y Laravel.',
    photo: '/assets/team/member1.jpg'
  },
  {
    name: 'Desarrollador 2',
    role: 'Frontend Developer',
    bio: 'Apasionado por el diseño y desarrollo de interfaces de usuario con Vue.js.',
    photo: '/assets/team/member2.jpg'
  },
  {
    name: 'Desarrollador 3',
    role: 'Full Stack Developer',
    bio: 'Experto en desarrollo full stack y arquitecturas de sistemas escalables.',
    photo: '/assets/team/member3.jpg'
  }
]);
</script>
