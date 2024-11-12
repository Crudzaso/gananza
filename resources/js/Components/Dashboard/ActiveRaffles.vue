<template>
  <section :class="['active-raffles my-8', theme.backgroundClass]">
    <h2 :class="['text-2xl font-bold mb-6 text-center', theme.textPrimary]">Rifas Activas</h2>

    <!-- Mensaje si no hay rifas -->
    <div v-if="raffles.data.length === 0" :class="theme.textSecondary">
      No hay rifas activas en este momento.
    </div>

    <!-- Grid de Rifas (1 fila con 3 cartas) -->
    <div v-else class="container mx-auto w-full grid grid-cols-1 md:grid-cols-3 gap-6">
      <RaffleCard
        v-for="raffle in raffles.data.slice(0, 3)"
        :key="raffle.id"
        :raffle="raffle"
      />
    </div>

    <!-- Botón para ver todas las rifas -->
    <div class="flex justify-center mt-8">
      <button
        @click="redirectToRaffles"
        :class="[theme.buttonPrimary]"
        class="py-2 px-6 rounded-lg hover:scale-105 transition"
      >
        ¡Ver todas las rifas!
      </button>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useDarkMode } from '@/composables/useDarkMode';
import RaffleCard from './RaffleCard.vue';

const raffles = ref({ data: [] });
const { isDarkMode } = useDarkMode();

const theme = computed(() => ({
  backgroundClass: isDarkMode.value
    ? 'bg-[#1a1a1c] shadow-lg' // Fondo oscuro para Dark Mode
    : 'bg-[#F5F5F7] shadow-sm ', // Fondo blanco suave para Light Mode
  textPrimary: isDarkMode.value ? 'text-white' : 'text-gray-900',
  textSecondary: isDarkMode.value ? 'text-gray-400' : 'text-gray-600',
  buttonPrimary: isDarkMode.value
    ? 'bg-blue-700 text-white hover:bg-blue-800'
    : 'bg-blue-600 text-white hover:bg-blue-700',
}));

const redirectToRaffles = () => {
  window.location.href = '/raffles/active';
};

const fetchRaffles = async () => {
  try {
    const response = await fetch('/raffles-actives');
    if (!response.ok) {
      throw new Error('Error al obtener las rifas activas');
    }
    raffles.value = await response.json();
  } catch (error) {
    console.error('Error fetching raffles:', error);
  }
};

onMounted(() => fetchRaffles());
</script>

<style scoped>
.active-raffles {
  border-radius: 12px;
  padding: 1rem;
}

button {
  transition: transform 0.2s;
}

button:hover {
  transform: scale(1.05);
}
</style>
