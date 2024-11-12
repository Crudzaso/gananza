<template>
  <div class="profile-page" :class="[isDarkMode ? 'dark' : '']">
    <!-- Sección Izquierda: Foto y Detalles del Usuario -->
    <div class="left-section">
      <div class="profile-card">
        <div class="photo-container">
          <img :src="`${authUser.profile_photo_url}?t=${new Date().getTime()}`" alt="Foto de perfil" class="profile-photo">
          <button class="btn-change-photo" @click="triggerFileInput">
            <i class="fas fa-camera"></i>
          </button>
          <!-- Input de archivo oculto -->
          <input type="file" ref="fileInput" class="hidden-file-input" @change="handleProfilePhotoChange"
            accept="image/*" v-show="true" />
        </div>

        <h2 class="user-name">{{ form.name }} {{ form.lastname }}</h2>
        <p class="user-email">{{ form.email }}</p>
        <div class="user-role">Cliente</div>
        <p class="member-since">Miembro desde hace 55 días</p>
        <button @click="showModal = true" class="btn-edit update">
          <span>Actualizar Perfil</span>
        </button>
        <button class="btn-dashboard">
          <span>
            <a href="/dashboard" style="color: white;">
              Ir al Dashboard
            </a>
          </span>
        </button>
      </div>
    </div>

    <!-- Sección Central: Rifas Activas -->
    <div class="center-section">
      <h3 class="section-title">Rifas Activas</h3>
      <div class="raffles-container">
        <div v-for="raffle in activeRaffles" :key="raffle.id" class="raffle-card">
          <div class="raffle-name">{{ raffle.name }}</div>
          <div class="raffle-date">Finaliza: {{ raffle.end_date }}</div>
        </div>
      </div>
    </div>

    <!-- Sección Derecha: Tickets Comprados -->
    <div class="right-section">
      <h3 class="section-title">Tickets Comprados</h3>
      <div class="tickets-display">
        <span class="tickets-count">{{ ticketsCount }}</span>
        <span class="tickets-label">Tickets</span>
      </div>
    </div>

    <!-- Barra de Progreso -->
    <div class="progress-section">
      <h3 class="section-title">Progreso de Tickets</h3>
      <div class="progress-container">
        <div class="progress-bar">
          <div class="progress-fill" :style="{ width: `${(ticketsCount / 5) * 100}%` }"></div>
        </div>
        <p class="progress-text">({{ ticketsCount }}/5) - ¡Completa 5 compras para recibir tu premio misterioso!</p>
      </div>
    </div>

    <!-- Modal Mejorado de Edición de Perfil -->
    <transition name="fade">
      <div v-if="showModal" class="modal-overlay" @click.self="showModal = false">
        <div class="modal-content">
          <div class="modal-header">
            <h2>Editar Perfil</h2>
            <button class="close-button" @click="showModal = false">&times;</button>
          </div>
          <form @submit.prevent="submit" class="edit-form">
            <div class="form-group">
              <label for="name">Nombre</label>
              <input id="name" v-model="form.name" type="text" class="input-field" placeholder="Tu nombre">
            </div>
            <div class="form-group">
              <label for="lastname">Apellido</label>
              <input id="lastname" v-model="form.lastname" type="text" class="input-field" placeholder="Tu apellido">
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input id="email" v-model="form.email" type="email" class="input-field" placeholder="Tu email">
            </div>
            <div class="modal-buttons">
              <button type="button" @click="showModal = false" class="btn-cancel">
                Cancelar
              </button>
              <button type="submit" class="btn-save">
                Guardar Cambios
              </button>
            </div>
          </form>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import { ref, computed, onMounted, nextTick } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import axios from 'axios';

export default {
  setup() {
    const authUser = computed(() => usePage().props.auth.user);
    const ticketsCount = ref(0);
    const activeRaffles = ref([]);
    const showModal = ref(false);
    const isDarkMode = ref(false);
    const fileInput = ref(null);


    const form = ref({
      name: authUser.value.name,
      lastname: authUser.value.lastname,
      email: authUser.value.email,
      profile_photo: null,
    });

    const fetchUserTickets = async () => {
      const response = await axios.get(`/api/user-tickets/${authUser.value.id}`);
      ticketsCount.value = response.data.tickets_count;
    };

    const fetchActiveRaffles = async () => {
      const response = await axios.get('/api/active-raffles');
      activeRaffles.value = response.data.active_raffles;
    };

    const handleProfilePhotoChange = (event) => {
      const file = event.target.files[0];
      if (file) {
        form.value.profile_photo = file;
        console.log('Foto de perfil seleccionada:', file);
        // Llama a la función para actualizar la foto de perfil
        updateProfilePhoto();
      } else {
        console.log('No se seleccionó ningún archivo.');
      }
    };

    const triggerFileInput = () => {
      nextTick(() => {
        if (fileInput.value) {
          console.log('Referencia encontrada, haciendo clic en el input.');
          fileInput.value.click();
        } else {
          console.error('Referencia al input de archivo no encontrada.');
        }
      });
    };

    const updateProfilePhoto = async () => {
      const formData = new FormData();

      // Verificar si hay una foto de perfil seleccionada
      if (form.value.profile_photo) {
        formData.append('profile_photo', form.value.profile_photo);
      } else {
        alert('Por favor, selecciona una foto de perfil.');
        return;
      }

      try {
        const response = await axios.post(route('user.update-photo', authUser.value.id), formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });

        authUser.value.profile_photo_url = response.data.profile_photo_url;
      } catch (error) {
        console.error('Error al actualizar la foto de perfil:', error);
        alert('Hubo un error al actualizar la foto de perfil.');
      }
    };
    const submit = async () => {
      const formData = new FormData();
      formData.append('name', form.value.name);
      formData.append('lastname', form.value.lastname);
      formData.append('email', form.value.email);

      // Adjuntar la foto de perfil al FormData
      if (form.value.profile_photo) {
        formData.append('profile_photo', form.value.profile_photo);
      }

      try {
        const response = await axios.post(`/users/${authUser.value.id}`, formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });

        alert(response.data.message);
        console.log('Respuesta del servidor:', response.data);
        authUser.value.profile_photo_url = response.data.profile_photo_url;
        showModal.value = false;
      } catch (error) {
        console.error('Error al actualizar el perfil:', error);
        alert('Hubo un error al actualizar el perfil.');
      }
    };

    onMounted(() => {
      fetchUserTickets();
      fetchActiveRaffles();
      isDarkMode.value = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    });

    return {
      authUser,
      ticketsCount,
      activeRaffles,
      showModal,
      form,
      isDarkMode,
      fetchUserTickets,
      fetchActiveRaffles,
      fileInput,
      handleProfilePhotoChange,
      triggerFileInput,
      submit,
    };
  },
};
</script>


<style scoped>
.profile-page {
  display: grid;
  grid-template-columns: 1fr 2fr 1fr;
  gap: 24px;
  padding: 24px;
  min-height: 100vh;
  background-color: #f7f9fc;
}

.left-section,
.center-section,
.right-section {
  background-color: #ffffff;
  border-radius: 16px;
  padding: 24px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.profile-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.photo-container {
  position: relative;
  margin-bottom: 20px;
}

.profile-photo {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  object-fit: cover;
  border: 4px solid #e0f0ff;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.btn-change-photo {
  position: absolute;
  bottom: 0;
  right: 0;
  background-color: #82caff;
  color: white;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 2px solid #ffffff;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-change-photo:hover {
  background-color: #5bb2ff;
  transform: scale(1.05);
}

.user-name {
  font-size: 1.5rem;
  font-weight: 600;
  color: #2c3e50;
  margin-bottom: 8px;
}

.user-email {
  color: #7f8c8d;
  margin-bottom: 12px;
}

.user-role {
  background-color: #e0f7fa;
  color: #00796b;
  padding: 4px 12px;
  border-radius: 9999px;
  font-size: 0.875rem;
  font-weight: 500;
  margin-bottom: 12px;
}

.member-since {
  color: #7f8c8d;
  font-size: 0.875rem;
  margin-bottom: 20px;
}

.btn-edit {
  background-color: #82caff;
  color: white;
  padding: 8px 24px;
  border-radius: 8px;
  font-weight: 500;
  transition: all 0.2s;
  width: 100%;
}

.btn-dashboard {
  background-color: #95ecec;
  color: black;
  padding: 8px 24px;
  border-radius: 8px;
  font-weight: 500;
  transition: all 0.2s;
  width: 100%;
}

.btn-dashboard:hover {
  background-color: #1dd6d0;
  transform: translateY(-1px);
}

.update {
  margin-bottom: 10px;
}

.btn-edit:hover {
  background-color: #5bb2ff;
  transform: translateY(-1px);
}

.section-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #2c3e50;
  margin-bottom: 16px;
}

.raffles-container {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.raffle-card {
  background-color: #f0f8ff;
  padding: 16px;
  border-radius: 8px;
  border: 1px solid #d6e9ff;
}

.raffle-name {
  font-weight: 500;
  color: #2c3e50;
}

.raffle-date {
  font-size: 0.875rem;
  color: #7f8c8d;
}

.tickets-display {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 24px;
}

.tickets-count {
  font-size: 3.5rem;
  font-weight: 700;
  color: #5bb2ff;
}

.tickets-label {
  color: #7f8c8d;
  font-size: 1.125rem;
}

.progress-section {
  grid-column: span 3;
  background-color: #ffffff;
  border-radius: 16px;
  padding: 24px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.progress-bar {
  height: 12px;
  background-color: #e0eaf1;
  border-radius: 9999px;
  overflow: hidden;
  margin: 16px 0;
}

.progress-fill {
  height: 100%;
  background: linear-gradient(to right, #82caff, #5bb2ff);
  transition: width 0.3s ease;
}

.progress-text {
  text-align: center;
  color: #7f8c8d;
  font-size: 0.875rem;
}

/* Modal Styles */
.modal-overlay {
  position: fixed;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.3);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 50;
}

.modal-content {
  background: #ffffff;
  border-radius: 16px;
  width: 90%;
  max-width: 500px;
  box-shadow: 0 20px 25px rgba(0, 0, 0, 0.1);
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 24px;
  border-bottom: 1px solid #e0eaf1;
}

.modal-header h2 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #2c3e50;
}

.close-button {
  font-size: 1.5rem;
  color: #7f8c8d;
  cursor: pointer;
}

.input-field {
  width: 100%;
  padding: 8px 12px;
  border: 1px solid #d6e9ff;
  border-radius: 8px;
  font-size: 0.875rem;
  transition: border-color 0.2s;
}

.input-field:focus {
  outline: none;
  border-color: #82caff;
}

.btn-cancel {
  padding: 8px 16px;
  border-radius: 8px;
  font-weight: 500;
  color: #7f8c8d;
  background-color: #ffffff;
  border: 1px solid #e0eaf1;
}

.btn-save {
  padding: 8px 16px;
  border-radius: 8px;
  font-weight: 500;
  color: white;
  background-color: #82caff;
}

.btn-save:hover {
  background-color: #5bb2ff;
}

/* Transiciones */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.hidden-file-input {
  display: none;
}
</style>
