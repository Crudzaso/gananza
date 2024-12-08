<template>
  <div :class="['hero-banner py-12 px-8 rounded-lg mb-5', theme.backgroundGradient]">
    <div class="container mx-auto flex flex-col items-center justify-center text-center">
      <h1 :class="['text-4xl md:text-5xl font-bold mb-4', theme.textPrimary]">¡Bienvenido a Gananza!</h1>
      <p :class="['text-lg md:text-xl mb-6', theme.textSecondary]">
        Únete a la plataforma líder en rifas: participa en rifas emocionantes o convierte tu idea en una rifa exitosa.
      </p>
      <div class="flex flex-col md:flex-row gap-4">
        <button
          @click="handleExploreRaffles"
          :class="['font-semibold py-2 px-6 rounded-lg transition w-full md:w-auto', theme.primaryButton]"
        >
          Explorar Rifas Activas
        </button>
        <button
          @click="handleBecomeOrganizer"
          :class="['font-semibold py-2 px-6 rounded-lg transition w-full md:w-auto', theme.secondaryButton]"
        >
          Organizar una Rifa
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { useDarkMode } from '@/composables/useDarkMode';
import { usePage } from '@inertiajs/vue3';

const authUser = computed(() => usePage().props.auth.user);

const { isDarkMode } = useDarkMode();

const handleExploreRaffles = () => {
  window.location.href = '/raffles/active';
};

const handleBecomeOrganizer = () => {
  const userRoles = authUser.value.roles;
  console.log(userRoles.value)
  if (userRoles.includes('organizador') || userRoles.includes('admin')) {
    window.location.href = '/raffles/admin/rifas';
  } else {
    window.location.href = '/registro-organizador';
  }
};
const theme = computed(() => ({
  backgroundGradient: isDarkMode.value
    ? 'bg-[#1a1a1c] shadow-lg' // Fondo oscuro para Dark Mode
    : 'bg-[#F5F5F7] shadow-sm', // Fondo blanco suave para Light Mode
  textPrimary: isDarkMode.value ? 'text-white' : 'text-gray-900',
  textSecondary: isDarkMode.value ? 'text-gray-300' : 'text-gray-700',
  primaryButton: isDarkMode.value
    ? 'bg-blue-700 text-white hover:bg-blue-800'
    : 'bg-blue-600 text-white hover:bg-blue-700',
  secondaryButton: isDarkMode.value
    ? 'bg-gray-800 text-blue-400 hover:bg-gray-700'
    : 'bg-gray-100 text-blue-600 hover:bg-gray-200',
}));
</script>

<style scoped>
.hero-banner {
  border-radius: 12px;
  transition: background 0.3s ease-in-out;
}

button {
  animation: fadeInUp 0.8s ease;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
