<template>
  <div :class="`${isDarkMode ? 'bg-[#242426] text-white' : 'bg-white'} p-6 rounded-lg shadow-lg mb-8`">
    <div class="space-y-4">
      <!-- Títulos del progreso -->
      <div class="flex justify-between items-center text-sm font-semibold">
        <span>{{ comprados }} tickets comprados</span>
        <span>{{ objetivo }} tickets objetivo</span>
      </div>

      <!-- Barra de progreso con diseño mejorado -->
      <div class="relative w-full h-4 bg-gray-200 rounded-full overflow-hidden">
        <div
          class="h-full rounded-full transition-all duration-500 ease-in-out"
          :style="{ width: progress + '%', backgroundColor: progressColor }"
        ></div>
        <!-- Indicador de progreso -->
        <span
          class="absolute inset-0 flex justify-center items-center text-xs font-bold"
          :class="`${isDarkMode ? 'text-white' : 'text-gray-800'}`"
        >
          {{ progress.toFixed(0) }}%
        </span>
      </div>

      <!-- Mensaje de incentivo -->
      <p :class="`${isDarkMode ? 'text-gray-400' : 'text-gray-600'} text-sm`">
        ¡Compra {{ ticketsRestantes }} tickets más para desbloquear tu premio misterioso!
      </p>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { useDarkMode } from '@/composables/useDarkMode';

// Definir las props con valores por defecto y validaciones
const props = defineProps({
  comprados: {
    type: Number,
    default: 0,
    validator: (value) => value >= 0,
  },
  objetivo: {
    type: Number,
    default: 10,
    validator: (value) => value > 0,
  },
});

const { isDarkMode } = useDarkMode();

// Computed para el progreso
const progress = computed(() => {
  // Evitar división por cero
  return props.objetivo > 0 ? (props.comprados / props.objetivo) * 100 : 0;
});

// Computed para obtener el color dinámico del progreso
const progressColor = computed(() => {
  if (progress.value < 50) return '#f87171'; // Rojo para menos del 50%
  if (progress.value < 80) return '#facc15'; // Amarillo para 50%-79%
  return '#34d399'; // Verde para 80% o más
});

// Computed para los tickets restantes
const ticketsRestantes = computed(() => Math.max(props.objetivo - props.comprados, 0));
</script>

<style scoped>
/* Estilos adicionales */
input:focus {
  outline: none;
  box-shadow: 0 0 10px rgba(0, 191, 255, 0.3);
}

/* Transiciones para suavizar el cambio de color y tamaño */
.transition-all {
  transition: all 0.3s ease-in-out;
}
</style>
