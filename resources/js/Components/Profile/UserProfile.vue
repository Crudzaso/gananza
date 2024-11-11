<template>
  <div :class="[isDarkMode ? 'bg-[#1a1a1c] text-white' : 'bg-[#F5F5F7] text-gray-900', 'min-h-screen p-6']">
    <!-- Encabezado del Perfil -->
    <div class="max-w-7xl mx-auto mb-8">
      <div class="flex flex-col md:flex-row items-center justify-between">
        <div class="flex items-center space-x-4 mb-6 md:mb-0">
          <!-- Foto de Perfil con opción de carga -->
          <div class="relative group cursor-pointer" @click="triggerFileInput">
            <input type="file" ref="fileInput" class="hidden" @change="handleFileChange" accept="image/*" />
            <div :class="[isDarkMode ? 'bg-blue-700' : 'bg-blue-600', 'w-24 h-24 rounded-full flex items-center justify-center overflow-hidden']">
              <img v-if="profilePicture" :src="profilePicture" alt="Foto de Perfil" class="object-cover w-full h-full" />
              <User v-else size="48" class="text-white" />
            </div>
            <div :class="[isDarkMode ? 'bg-black bg-opacity-50 text-white' : 'bg-black bg-opacity-50 text-white', 'absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity']">
              <span>Cambiar Foto</span>
            </div>
          </div>

          <!-- Nombre y Fecha de Miembro -->
          <div>
            <h1 :class="[isDarkMode ? 'text-blue-400' : 'text-blue-600', 'text-3xl font-bold']">{{ user.name }}</h1>
            <p :class="[isDarkMode ? 'text-gray-300' : 'text-gray-700']">Miembro desde {{ formatDate(user.created_at) }}</p>
          </div>
        </div>

        <!-- Botón de regreso al Dashboard -->
        <button :class="[isDarkMode ? 'bg-blue-700 hover:bg-blue-800' : 'bg-blue-600 hover:bg-blue-700', 'text-white px-4 py-2 rounded-lg']">
          <a href="/dashboard">
            <span style="color: white;">← Volver al Dashboard</span>
          </a>
        </button>
      </div>
    </div>

    <!-- Contenido Principal -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <div class="col-span-2">
        <PersonalInfo :user="user" />
        <RewardProgress :comprados="user.ticketsComprados" :objetivo="user.ticketsObjetivo" class="mt-6" />
        <ActivityChart :data="ticketData" class="mt-6" />
      </div>

      <div class="space-y-4">
        <StatCard title="Tickets Comprados" :value="user.ticketsComprados" icon="Ticket" />
        <StatCard title="Rifas Participadas" :value="user.rifasParticipadas" icon="Gift" />
        <StatCard title="Rifas Ganadas" :value="user.rifasGanadas" icon="Trophy" />
        <StatCard title="Nivel de Usuario" :value="user.nivel" icon="Star" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, defineProps } from 'vue';
import { useDarkMode } from '@/composables/useDarkMode';
import { useRouter } from 'vue-router';
import { User } from 'lucide-vue-next';
import StatCard from '@/Components/Profile/StatCard.vue';
import RewardProgress from '@/Components/Profile/RewardProgress.vue';
import ActivityChart from '@/Components/Profile/ActivityChart.vue';
import PersonalInfo from '@/Components/Profile/PersonalInfo.vue';

const { isDarkMode } = useDarkMode();
const router = useRouter();

const props = defineProps({
  user: {
    type: Object,
    default: () => ({
      name: 'Usuario Desconocido',
      created_at: 'N/A',
      ticketsComprados: 0,
      ticketsObjetivo: 10,
      rifasParticipadas: 0,
      rifasGanadas: 0,
      nivel: 'Bronce',
    }),
  },
});

const fileInput = ref(null);
const profilePicture = ref(null);

const ticketData = [
  { date: '2024-11-05', tickets: 2 },
  { date: '2024-11-06', tickets: 1 },
  { date: '2024-11-07', tickets: 3 },
  { date: '2024-11-08', tickets: 0 },
  { date: '2024-11-09', tickets: 2 },
  { date: '2024-11-10', tickets: 1 },
  { date: '2024-11-11', tickets: 2 },
];

const formatDate = (dateString) => {
  if (!dateString) return 'Fecha desconocida';
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(dateString).toLocaleDateString('es-ES', options);
};

const triggerFileInput = () => {
  if (fileInput.value) {
    fileInput.value.click();
  }
};

const handleFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      profilePicture.value = e.target.result;
    };
    reader.readAsDataURL(file);
  }
};

const navigateToDashboard = () => {
  router.push('/dashboard');
};
</script>

<style scoped>
.min-h-screen {
  min-height: 100vh;
}

img {
  border-radius: 50%;
}

.group:hover .opacity-100 {
  opacity: 1;
}

.hover\:opacity-80:hover {
  opacity: 0.8;
}

.profile-picture {
  transition: background-color 0.3s ease;
}

.profile-overlay {
  transition: opacity 0.3s ease;
}
</style>
