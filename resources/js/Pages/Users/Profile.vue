<template>
  <div class="profile-page" :style="{ background: isDarkMode ? '#121212' : '#F9FAFB' }">
    <!-- Sección Izquierda: Foto y Detalles del Usuario -->
    <div class="left-section"
      :style="{ background: isDarkMode ? '#1E1E1E' : '#FFFFFF', color: isDarkMode ? '#E0E0E0' : '#212121' }">
      <div class="profile-card" :style="{ background: isDarkMode ? '#1E1E1E' : '#FFFFFF' }">
        <div class="photo-container">
          <img :src="`${authUser.profile_photo_url}?t=${new Date().getTime()}`" alt="Foto de perfil"
            class="profile-photo">
          <button class="btn-change-photo" :style="{ background: isDarkMode ? '#42A5F5' : '#1565C0' }"
            @click="triggerFileInput">
            <i class="fas fa-camera"></i>
          </button>
          <input type="file" ref="fileInput" class="hidden-file-input" @change="handleProfilePhotoChange"
            accept="image/*" />
        </div>

        <h2 class="user-name" :style="{ color: isDarkMode ? '#E0E0E0' : '#212121' }">{{ form.name }} {{ form.lastname }}
        </h2>
        <p class="user-email" :style="{ color: isDarkMode ? '#B0BEC5' : '#757575' }">{{ form.email }}</p>
        <div class="user-role"
          :style="{ background: isDarkMode ? '#333333' : '#E0F7FA', color: isDarkMode ? '#82C7C7' : '#00796B' }">{{
            authUser.roles[0] }}
        </div>
        <button @click="showModal = true" :style="{ background: isDarkMode ? '#42A5F5' : '#1565C0', color: '#FFFFFF' }"
          class="btn-edit update">Actualizar Perfil</button>
        <button class="btn-dashboard" :style="{ background: isDarkMode ? '#26C6DA' : '#95ECEC', color: '#FFFFFF' }">
          <a href="/dashboard" style="color: white;">Ir al Dashboard</a>
        </button>
      </div>
    </div>

    <!-- Sección Central: Rifas Activas -->
    <div class="center-section"
      :style="{ background: isDarkMode ? '#1E1E1E' : '#FFFFFF', color: isDarkMode ? '#E0E0E0' : '#212121' }">
      <h3 class="section-title" :style="{ color: isDarkMode ? '#E0E0E0' : '#212121' }">Rifas Activas</h3>
      <div class="raffles-container">
        <div v-for="raffle in activeRaffles" :key="raffle.id" class="raffle-card"
          :style="{ background: isDarkMode ? '#2A2A2A' : '#F0F8FF' }">
          <div class="raffle-name" :style="{ color: isDarkMode ? '#E0E0E0' : '#212121' }">{{ raffle.name }}</div>
          <div class="raffle-date" :style="{ color: isDarkMode ? '#B0BEC5' : '#757575' }">Finaliza: {{ raffle.end_date
            }}</div>
        </div>
      </div>
    </div>

    <!-- Sección Derecha: Tickets Comprados -->
    <div class="right-section"
      :style="{ background: isDarkMode ? '#1E1E1E' : '#FFFFFF', color: isDarkMode ? '#E0E0E0' : '#212121' }">
      <h3 class="section-title" :style="{ color: isDarkMode ? '#E0E0E0' : '#212121' }">Tickets Comprados</h3>
      <div class="tickets-display">
        <span class="tickets-count" :style="{ color: isDarkMode ? '#42A5F5' : '#5BB2FF' }">{{ ticketsCount }}</span>
        <span class="tickets-label" :style="{ color: isDarkMode ? '#B0BEC5' : '#757575' }">Tickets</span>
      </div>
    </div>

    <!-- Barra de Progreso -->
    <div class="progress-section" :style="{ background: isDarkMode ? '#1E1E1E' : '#FFFFFF' }">
      <h3 class="section-title" :style="{ color: isDarkMode ? '#E0E0E0' : '#212121' }">Progreso de Tickets</h3>
      <div class="progress-container">
        <div class="progress-bar">
          <div class="progress-fill"
            :style="{ width: `${(ticketsCount / 5) * 100}%`, background: isDarkMode ? '#42A5F5' : '#5BB2FF' }"></div>
        </div>
        <p class="progress-text" :style="{ color: isDarkMode ? '#B0BEC5' : '#757575' }">({{ ticketsCount }}/5) -
          ¡Completa 5 compras para recibir tu premio misterioso!</p>
      </div>
    </div>

    <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
      <div class="modal-container" :style="{
        background: isDarkMode ? '#1E1E1E' : '#FFFFFF',
        color: isDarkMode ? '#E0E0E0' : '#212121'
      }">
        <div class="modal-header">
          <h2 :style="{ color: isDarkMode ? '#E0E0E0' : '#212121' }">
            Actualizar Perfil
          </h2>
          <button @click="closeModal" class="close-button" :style="{
            color: isDarkMode ? '#B0BEC5' : '#757575',
            background: 'transparent'
          }">
            ×
          </button>
        </div>

        <form @submit.prevent="submit" class="modal-form">
          <div class="form-grid">
            <div class="form-group">
              <label :style="{ color: isDarkMode ? '#B0BEC5' : '#757575' }">Nombre</label>
              <input v-model="form.name" type="text" :style="inputStyle" required />
            </div>

            <div class="form-group">
              <label :style="{ color: isDarkMode ? '#B0BEC5' : '#757575' }">Apellido</label>
              <input v-model="form.lastname" type="text" :style="inputStyle" required />
            </div>

            <div class="form-group">
              <label :style="{ color: isDarkMode ? '#B0BEC5' : '#757575' }">Tipo de Documento</label>
              <select v-model="form.document_type" :style="inputStyle" required>
                <option value="">Seleccionar</option>
                <option value="DNI">DNI</option>
                <option value="Pasaporte">Pasaporte</option>
                <option value="CE">Carné de Extranjería</option>
              </select>
            </div>

            <div class="form-group">
              <label :style="{ color: isDarkMode ? '#B0BEC5' : '#757575' }">Número de Documento</label>
              <input v-model="form.document" type="text" :style="inputStyle" required />
            </div>

            <div class="form-group">
              <label :style="{ color: isDarkMode ? '#B0BEC5' : '#757575' }">Teléfono</label>
              <input v-model="form.phone_number" type="tel" :style="inputStyle" required />
            </div>

            <div class="form-group">
              <label :style="{ color: isDarkMode ? '#B0BEC5' : '#757575' }">Correo Electrónico</label>
              <input v-model="form.email" type="email" :style="inputStyle" required />
            </div>
          </div>

          <div class="modal-actions">
            <button type="button" @click="closeModal" :style="buttonCancelStyle">
              Cancelar
            </button>
            <button type="submit" :style="buttonSaveStyle">
              Guardar Cambios
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>


<script>
import { ref, computed, onMounted, nextTick } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import axios from 'axios';
import { useDarkMode } from '@/composables/useDarkMode';

export default {
  setup() {
    const authUser = computed(() => usePage().props.auth.user);
    const ticketsCount = ref(0);
    const activeRaffles = ref([]);
    const showModal = ref(false);
    const fileInput = ref(null);
    const { isDarkMode } = useDarkMode();

    const form = ref({
      name: authUser.value?.name || '',
      lastname: authUser.value?.lastname || '',
      email: authUser.value?.email || '',
      document: authUser.value?.document || '',
      document_type: authUser.value?.document_type || '',
      phone_number: authUser.value?.phone_number || '',
      profile_photo: null,
    });
    const inputStyle = computed(() => ({
      width: '100%',
      background: isDarkMode.value ? '#333333' : '#FFFFFF',
      color: isDarkMode.value ? '#E0E0E0' : '#212121',
      border: isDarkMode.value ? '1px solid #555' : '1px solid #D6E9FF',
      borderRadius: '8px',
      padding: '10px',
      marginBottom: '16px',
    }));

    const buttonCancelStyle = computed(() => ({
      background: isDarkMode.value ? '#333333' : '#E0EAF1',
      color: isDarkMode.value ? '#B0BEC5' : '#757575',
      border: isDarkMode.value ? '1px solid #555' : '1px solid #D6E9FF',
      borderRadius: '8px',
      padding: '10px 20px',
      marginRight: '8px',
      cursor: 'pointer',
    }));

    const buttonSaveStyle = computed(() => ({
      background: isDarkMode.value ? '#42A5F5' : '#1565C0',
      color: '#FFFFFF',
      borderRadius: '8px',
      padding: '10px 20px',
      cursor: 'pointer',
    }));

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

    const closeModal = () => {
      showModal.value = false;
    };
    const submit = async () => {
      const payload = {
        name: form.value.name,
        lastname: form.value.lastname,
        document: form.value.document,
        document_type: form.value.document_type,
        phone_number: form.value.phone_number,
        email: form.value.email,
      };

      try {
        // Hacemos una solicitud PUT en lugar de POST
        const response = await axios.put(`/users/${authUser.value.id}`, payload, {
          headers: {
            'Content-Type': 'application/json',
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
    });

    return {
      authUser,
      ticketsCount,
      activeRaffles,
      showModal,
      closeModal,
      form,
      isDarkMode,
      fetchUserTickets,
      fetchActiveRaffles,
      fileInput,
      handleProfilePhotoChange,
      triggerFileInput,
      submit,
      inputStyle,
      buttonCancelStyle,
      buttonSaveStyle,
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

.form-container {
  display: flex;
  flex-direction: column;
  gap: 12px;
  /* Espaciado entre los campos */
  padding: 16px;
}

.input-field {
  width: 100%;
  padding: 8px 12px;
  border: 1px solid #d6e9ff;
  border-radius: 8px;
  font-size: 0.9rem;
}

.input-field:focus {
  outline: none;
  border-color: #82caff;
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

/* Modal Styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-container {
  width: 90%;
  max-width: 600px;
  border-radius: 12px;
  padding: 24px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.close-button {
  border: none;
  background: transparent;
  font-size: 24px;
  cursor: pointer;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.full-width {
  grid-column: span 2;
}

label {
  margin-bottom: 8px;
  font-weight: 500;
}

input,
select {
  padding: 10px;
  border-radius: 8px;
}

.modal-actions {
  display: flex;
  justify-content: flex-end;
  margin-top: 20px;
}

.modal-actions button {
  margin-left: 10px;
}

@media screen and (max-width: 1024px) {
  .profile-page {
    grid-template-columns: 1fr;
    /* Stack columns vertically */
    grid-template-rows: auto;
    /* Allow rows to adjust dynamically */
    gap: 16px;
    padding: 16px;
  }

  .left-section,
  .center-section,
  .right-section,
  .progress-section {
    grid-column: span 1;
    /* Ensure each section takes full width */
  }

  .profile-photo {
    width: 100px;
    height: 100px;
  }

  .user-name {
    font-size: 1.25rem;
  }

  .raffles-container,
  .tickets-display {
    align-items: center;
  }
}

@media screen and (max-width: 768px) {
  .profile-page {
    padding: 12px;
    gap: 12px;
  }

  .left-section,
  .center-section,
  .right-section {
    padding: 16px;
  }

  .btn-edit,
  .btn-dashboard {
    width: 100%;
    margin-bottom: 8px;
  }

}

@media screen and (max-width: 480px) {
  .profile-page {
    padding: 8px;
    gap: 8px;
  }

  .user-name {
    font-size: 1.1rem;
  }

  .user-email {
    font-size: 0.9rem;
  }

  .tickets-count {
    font-size: 3rem;
  }

  .tickets-label {
    font-size: 1rem;
  }
}
</style>
