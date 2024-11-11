<template>
    <div v-if="isVisible" class="modal-overlay">
      <div class="modal-content" :style="{ background: theme.cardBackground, color: theme.textColor }">
        <button class="modal-close" @click="closeModal">✖</button>
        <h3 class="modal-title" :style="{ color: theme.textColor }">Filtros Avanzados</h3>
  
        <!-- Icono del Modal -->
        <div class="modal-icon">
          <img :src="isDarkMode ? '/assets/media/gananza/filter-light.svg' : '/assets/media/gananza/filter-dark.svg'" alt="Filter Icon" />
        </div>
  
        <!-- Formulario de Filtros -->
        <div class="filters-form">
          <input
            type="number"
            v-model="filters.minPrice"
            placeholder="Precio mínimo"
            class="filter-input"
          />
          <input
            type="number"
            v-model="filters.maxPrice"
            placeholder="Precio máximo"
            class="filter-input"
          />
          <input
            type="date"
            v-model="filters.endDate"
            class="filter-input"
          />
        </div>
  
        <!-- Acciones del Modal -->
        <div class="modal-actions">
          <button @click="applyFilters" :style="{ background: theme.primary }" class="modal-button confirm">
            Aplicar Filtros
          </button>
          <button @click="closeModal" :style="{ background: theme.emphasis }" class="modal-button cancel">
            Cancelar
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  import { useDarkMode } from '@/composables/useDarkMode';
  
  const emit = defineEmits(['apply-filters', 'close']);
  const isVisible = ref(true);
  const filters = ref({
    minPrice: '',
    maxPrice: '',
    endDate: '',
  });
  
  const { isDarkMode } = useDarkMode();
  
  const theme = computed(() => ({
    primary: isDarkMode.value ? '#42A5F5' : '#1565C0',
    textColor: isDarkMode.value ? '#FFFFFF' : '#212121',
    cardBackground: isDarkMode.value ? '#303030' : '#F5F5F5',
    emphasis: isDarkMode.value ? '#EF5350' : '#D32F2F',
  }));
  
  const closeModal = () => {
    emit('close');
  };
  
  const applyFilters = () => {
    emit('apply-filters', filters.value);
  };
  </script>
  
  <style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.6);
  backdrop-filter: blur(12px); /* Añadir efecto de desenfoque */
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
  animation: fadeIn 0.3s ease-in-out;
}

  
  .modal-content {
    width: 500px;
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
    width: 40px;
    height: 40px;
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
  }
  
  .modal-title {
    font-size: 1.5em;
    font-weight: 600;
    margin-bottom: 20px;
  }
  
  .filters-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
  }
  
  .filter-input {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 1em;
    color: black;
  }
  
  .modal-actions {
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
    gap: 10px;
  }
  
  .modal-button {
    flex: 1;
    padding: 12px 20px;
    border-radius: 12px;
    color: #ffffff;
    font-weight: bold;
    cursor: pointer;
    transition: transform 0.3s, box-shadow 0.3s;
  }
  
  .modal-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
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
  </style>
  