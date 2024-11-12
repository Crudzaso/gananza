<template>
  <div :class="[isDarkMode ? 'bg-[#1a1a1c] text-white' : 'bg-[#F5F5F7] text-gray-900', 'min-h-screen p-6']">
    <!-- Contenedor del Perfil -->
    <div class="profile-container">
      <!-- Encabezado del Perfil -->
      <div class="profile-header">
        <div class="flex flex-col items-center gap-4">
          <!-- Foto de Perfil e Información del Usuario -->
          <div class="profile-picture-container" @click="triggerFileInput">
            <input type="file" ref="fileInput" class="hidden" @change="handleFileChange" accept="image/*" />
            <div class="profile-picture">
              <img v-if="profilePicture" :src="profilePicture" alt="Foto de Perfil" />
              <User v-else size="60" class="text-white" />
            </div>
          </div>
          <div class="user-details text-center">
            <h1 class="user-name" style="color: white;">{{ user.name }}</h1>
            <p class="user-location">📍 {{ user.location || 'SF, Bay Area' }}</p>
            <p class="user-email">{{ user.email }}</p>
          </div>
          <div class="action-buttons flex gap-4">
            <button class="follow-btn">Follow</button>
            <button class="hire-btn">Hire Me</button>
          </div>
        </div>

        <!-- Estadísticas del Usuario -->
        <div class="user-stats grid grid-cols-3 gap-4 mt-6">
          <StatCard title="Earnings" :value="user.earnings" icon="DollarSign" />
          <StatCard title="Projects" :value="user.projects" icon="Briefcase" />
          <StatCard title="Success Rate" :value="user.successRate + '%'" icon="Percent" />
        </div>
      </div>
    </div>

    <!-- Contenido Principal -->
    <div class="main-content grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
      <!-- Información del Usuario y Progreso -->
      <div>
        <PersonalInfo :user="user" />
        <RewardProgress :comprados="user.ticketsComprados" :objetivo="user.ticketsObjetivo" class="mt-6" />
        <ActivityChart :data="ticketData" class="mt-6" />
      </div>

      <!-- Tarjetas de Estadísticas -->
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
import { User } from 'lucide-vue-next';
import StatCard from '@/Components/Profile/StatCard.vue';
import RewardProgress from '@/Components/Profile/RewardProgress.vue';
import ActivityChart from '@/Components/Profile/ActivityChart.vue';
import PersonalInfo from '@/Components/Profile/PersonalInfo.vue';

const { isDarkMode } = useDarkMode();
const fileInput = ref(null);
const profilePicture = ref(null);

const props = defineProps({
  user: {
    type: Object,
    default: () => ({
      name: 'Usuario Desconocido',
      email: '',
      location: '',
      earnings: 0,
      projects: 0,
      successRate: 0,
      ticketsComprados: 0,
      ticketsObjetivo: 10,
      rifasParticipadas: 0,
      rifasGanadas: 0,
      nivel: 'Bronce',
    }),
  },
});

const ticketData = [
  { date: '2024-11-05', tickets: 2 },
  { date: '2024-11-06', tickets: 1 },
  { date: '2024-11-07', tickets: 3 },
  { date: '2024-11-09', tickets: 2 },
  { date: '2024-11-10', tickets: 1 },
  { date: '2024-11-11', tickets: 2 },
];

const triggerFileInput = () => {
  if (fileInput.value) fileInput.value.click();
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
</script>

<style scoped>
.min-h-screen {
  min-height: 100vh;
}

.profile-container {
  background-color: #1a1a1c;
  color: #f5f5f7;
  padding: 20px;
  border-radius: 12px;
  max-width: 900px;
  margin: 0 auto;
}

.profile-header {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.profile-picture {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #2d2d30;
}

.action-buttons button {
  padding: 10px 20px;
  border-radius: 8px;
  font-weight: bold;
}

.follow-btn {
  background-color: #3a3a3d;
  color: #f5f5f7;
}

.hire-btn {
  background-color: #007bff;
  color: #f5f5f7;
}
</style>
