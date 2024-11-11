<template>
  <div :class="[isDarkMode ? 'bg-[#1c1c1e] text-white' : 'bg-[#f9f9f9] text-gray-900', 'p-6 rounded-lg shadow-lg mb-8']">
    <h2 class="text-xl font-semibold mb-4 text-center">Actividad de Tickets</h2>
    <div class="chart-wrapper">
      <Bar :data="chartData" :options="chartOptions" />
    </div>
  </div>
</template>
<script setup>
import { ref, computed, watch } from 'vue';
import { Bar } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from 'chart.js';
import { useDarkMode } from '@/composables/useDarkMode';

// Registrar componentes de Chart.js
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

const { isDarkMode } = useDarkMode();
const props = defineProps(['data']);

// Verificar si los datos son válidos
const isDataArray = computed(() => Array.isArray(props.data) && props.data.length > 0);

// Datos del gráfico
const chartData = ref({
  labels: [],
  datasets: [],
});

// Actualizar los datos del gráfico
const updateChartData = () => {
  if (isDataArray.value) {
    chartData.value = {
      labels: props.data.map((item) => item.date),
      datasets: [
        {
          label: 'Tickets',
          data: props.data.map((item) => item.tickets),
          backgroundColor: isDarkMode.value ? '#4f46e5' : '#2563eb',
          borderColor: isDarkMode.value ? '#6366f1' : '#1d4ed8',
          borderWidth: 1,
          borderRadius: 8,
        },
      ],
    };
  }
};

// Opciones del gráfico
const chartOptions = computed(() => ({
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: true,
      labels: {
        color: isDarkMode.value ? '#E0E0E0' : '#212121',
        font: { size: 14 },
      },
    },
    tooltip: {
      enabled: true,
      backgroundColor: isDarkMode.value ? '#333' : '#fff',
      titleColor: isDarkMode.value ? '#fff' : '#000',
      bodyColor: isDarkMode.value ? '#ddd' : '#333',
    },
  },
  scales: {
    x: {
      grid: { display: false },
      ticks: { color: isDarkMode.value ? '#E0E0E0' : '#212121' },
    },
    y: {
      grid: { color: isDarkMode.value ? '#3a3a3c' : '#e0e0e0' },
      ticks: { color: isDarkMode.value ? '#E0E0E0' : '#212121' },
    },
  },
}));

// Observar cambios en los datos y actualizar el gráfico
watch(() => props.data, updateChartData, { immediate: true });
</script>

<style scoped>

.chart-wrapper {
  height: 300px;
  max-height: 400px;
  overflow: hidden;
}
h2 {
  text-align: center;
}

.chart-container {
  position: relative;
  height: 300px;
}
</style>
