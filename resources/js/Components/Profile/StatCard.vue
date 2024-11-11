<template>
  <div :class="[isDarkMode ? 'bg-[#242426] text-white' : 'bg-white text-gray-900', 'p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300']">
    <div class="flex items-center justify-between">
      <!-- Información del título y valor -->
      <div>
        <p :class="[isDarkMode ? 'text-gray-400' : 'text-gray-600', 'text-sm']">{{ title }}</p>
        <p class="text-2xl font-bold mt-1">{{ formattedValue }}</p>
      </div>
      <!-- Icono dinámico -->
      <component :is="icon" :class="[isDarkMode ? 'text-yellow-500' : 'text-blue-600']" size="28" />
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { useDarkMode } from '@/composables/useDarkMode';

// Definir las props con valores por defecto
const props = defineProps({
  title: {
    type: String,
    default: 'Estadística',
  },
  value: {
    type: [String, Number],
    default: 0,
  },
  icon: {
    type: String,
    default: 'User', // Icono por defecto si no se proporciona
  },
});

// Composable para manejar el modo oscuro
const { isDarkMode } = useDarkMode();

// Formatear el valor numérico
const formattedValue = computed(() => {
  if (typeof props.value === 'number') {
    return new Intl.NumberFormat('es-ES').format(props.value);
  }
  return props.value;
});
</script>

<style scoped>
/* Estilos adicionales para efectos de hover */
.hover\:shadow-xl:hover {
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
}
</style>
