<template>
  <div :class="['raffle-card shadow-lg rounded-lg p-4 flex flex-col items-center gap-4 mx-auto', theme.cardBackground]">
    <img
      src="../../../../public/assets/media/auth/Letra-Gananza.svg"
      alt="Premio"
      class="h-32 w-32 object-cover rounded-lg mb-3"
    />
    <h3 :class="['text-lg font-semibold', theme.textPrimary]">{{ raffle.name }}</h3>
    <p :class="theme.textSecondary">Organizador: {{ raffle.organizer.name }}</p>
    <p :class="theme.textSecondary">
      Precio/Ticket: <span :class="theme.textHighlight">${{ raffle.ticket_price }}</span>
    </p>
    <p :class="theme.textSecondary">Fecha de Finalización: {{ raffle.end_date }}</p>
    <p :class="theme.timeRemaining">
      Tiempo Restante: {{ calculateTimeLeft(raffle.end_date) }}
    </p>
    <button
      @click="handleBuyTicket"
      :class="theme.buttonPrimary"
      class="py-2 px-4 rounded-lg hover:scale-105 transition"
    >
      Comprar
    </button>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { useDarkMode } from '@/composables/useDarkMode';

defineProps({
  raffle: Object,
});

const { isDarkMode } = useDarkMode();

const theme = computed(() => ({
  cardBackground: isDarkMode.value
    ? 'bg-[#1c1c1e] shadow-lg' // Fondo oscuro con sombra para Dark Mode
    : 'bg-[#f9f9f9] ', // Fondo blanco suave con sombra para Light Mode
  textPrimary: isDarkMode.value ? 'text-white' : 'text-gray-900',
  textSecondary: isDarkMode.value ? 'text-gray-400' : 'text-gray-700',
  textHighlight: isDarkMode.value ? 'text-yellow-300' : 'text-yellow-500',
  timeRemaining: isDarkMode.value ? 'text-red-300 font-semibold' : 'text-red-500 font-semibold',
  buttonPrimary: isDarkMode.value
    ? 'bg-blue-700 text-white hover:bg-blue-800'
    : 'bg-blue-600 text-white hover:bg-blue-700',
}));

const handleBuyTicket = () => {
  alert('Redirigiendo a la compra de ticket...');
};

const calculateTimeLeft = (endDate) => {
  const end = new Date(endDate);
  const now = new Date();
  const timeLeft = end - now;

  const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
  const hours = Math.floor((timeLeft / (1000 * 60 * 60)) % 24);
  const minutes = Math.floor((timeLeft / 1000 / 60) % 60);

  return `${days}d ${hours}h ${minutes}m`;
};
</script>

<style scoped>
.raffle-card {
  width: 100%;
  max-width: 320px;
  margin: 0.5rem; /* Añadir margen para evitar sombras cortadas */
  transition: transform 0.2s;
}

.raffle-card:hover {
  transform: translateY(-5px);
}
</style>