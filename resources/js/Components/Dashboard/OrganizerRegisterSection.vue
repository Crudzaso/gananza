<template>
  <section :class="['organizer-register-section my-12', theme.sectionBackground]">
    <div class="container mx-auto text-center">
      <h2 :class="['text-3xl font-bold mb-4', theme.textPrimary]">
        ¿Quieres organizar una rifa?
      </h2>
      <p :class="['text-lg mb-6', theme.textSecondary]">
        Únete a Gananza como organizador y empieza a crear rifas emocionantes para tu comunidad.
        Gana dinero mientras ofreces premios increíbles.
      </p>
      <button @click="redirectToRegister" :class="[theme.buttonPrimary]"
        class="px-8 py-3 rounded-lg text-lg font-semibold hover:scale-105 transition">
        ¡Regístrate como Organizador!
      </button>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue';
import { useDarkMode } from '@/composables/useDarkMode';
import { usePage } from '@inertiajs/vue3';

const authUser = computed(() => usePage().props.auth.user);

const { isDarkMode } = useDarkMode();

const theme = computed(() => ({
  sectionBackground: isDarkMode.value
    ? 'bg-[#1a1a1c] ' // Fondo oscuro para Dark Mode
    : 'bg-[#F5F5F7] shadow-sm', // Fondo claro para Light Mode
  textPrimary: isDarkMode.value ? 'text-white' : 'text-gray-900',
  textSecondary: isDarkMode.value ? 'text-gray-400' : 'text-gray-700',
  buttonPrimary: isDarkMode.value
    ? 'bg-blue-700 text-white hover:bg-blue-800'
    : 'bg-blue-600 text-white hover:bg-blue-700',
}));

const redirectToRegister = () => {
  const userRoles = authUser.value.roles;
  if (userRoles.includes('organizador') || userRoles.includes('admin')) {
    window.location.href = '/raffles/admin/rifas';
  } else {
    window.location.href = '/registro-organizador';
  }
};
</script>

<style scoped>
.organizer-register-section {
  padding: 4rem 2rem;
  border-radius: 12px;
  transition: background-color 0.3s ease-in-out;
}

button {
  transition: transform 0.2s;
}

button:hover {
  transform: scale(1.05);
}
</style>