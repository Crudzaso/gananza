<template>
  <div v-if="isVisible" class="modal-overlay">
    <div class="modal-content" :style="{ background: theme.cardBackground, color: theme.textColor }">
      <button class="modal-close" @click="closeModal">✖</button>
      <div class="modal-icon">
        <img :src="isDarkMode ? '/assets/media/gananza/warning-light.svg' : '/assets/media/gananza/warning-dark.svg'" alt="Info Icon" />
      </div>
      <h3 class="modal-message">{{ message }}</h3>
      <div class="modal-actions">
        <button @click="closeModal" :style="{ background: theme.emphasis }" class="modal-button cancel">
          <img src="/assets/media/gananza/no-light.svg" alt="Cancelar" class="button-icon" /> Cancelar
        </button>
        <button @click="confirmAction" :style="{ background: theme.primary }" class="modal-button confirm">
          <img src="/assets/media/gananza/ok-light.svg" alt="Aceptar" class="button-icon" /> Aceptar
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { useDarkMode } from '@/composables/useDarkMode';
import { useConfirmationModal } from '@/composables/useConfirmationModal';

const { isVisible, message, closeModal, confirmAction } = useConfirmationModal();
const { isDarkMode } = useDarkMode();

const theme = computed(() => ({
  primary: isDarkMode.value ? '#42A5F5' : '#1565C0',
  textColor: isDarkMode.value ? '#FFFFFF' : '#212121',
  cardBackground: isDarkMode.value ? '#2A2A2A' : '#FFFFFF',
  emphasis: isDarkMode.value ? '#FF5252' : '#D32F2F',
  overlay: isDarkMode.value ? 'rgba(0, 0, 0, 0.7)' : 'rgba(255, 255, 255, 0.7)',
}));
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.6);
  backdrop-filter: blur(12px);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
  animation: fadeIn 0.3s ease-in-out;
}

.modal-content {
  width: 400px;
  padding: 40px;
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
  text-align: center;
  transform: scale(0.95);
  animation: scaleUp 0.4s cubic-bezier(0.25, 1, 0.5, 1) forwards;
  position: relative;
}

.modal-icon {
  margin-bottom: 20px;
}

.modal-icon img {
  width: 50px;
  height: 50px;
  animation: bounce 0.5s ease;
}

.modal-close {
  position: absolute;
  top: 20px;
  right: 20px;
  background: none;
  border: none;
  font-size: 1.5em;
  cursor: pointer;
  color: inherit;
  transition: transform 0.2s;
}

.modal-close:hover {
  transform: scale(1.1);
}

.modal-message {
  font-size: 1.2em;
  font-weight: 600;
  margin-bottom: 20px;
  color: inherit;
}

.modal-actions {
  display: flex;
  justify-content: space-around;
  gap: 20px;
}

.modal-button {
  flex: 1;
  padding: 12px 20px;
  border: none;
  border-radius: 12px;
  color: #ffffff;
  font-size: 1em;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  transition: transform 0.3s, box-shadow 0.3s;
}

.modal-button:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

.button-icon {
  width: 20px;
  height: 20px;
}

.confirm {
  background-color: #4caf50;
}

.cancel {
  background-color: #f44336;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes scaleUp {
  from {
    transform: scale(0.9);
  }
  to {
    transform: scale(1);
  }
}

@keyframes bounce {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-10px);
  }
}
</style>
