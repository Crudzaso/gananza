<!-- FilterModal.vue -->
<template>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-xl font-bold mb-4">Filtrar Rifas</h3>
        
        <div class="space-y-4">
          <!-- Rango de precio -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              Precio del Ticket
            </label>
            <div class="flex gap-4">
              <div class="flex-1">
                <input
                  type="number"
                  v-model="localFilters.minPrice"
                  placeholder="Mínimo"
                  class="w-full px-3 py-2 border rounded-lg"
                />
              </div>
              <div class="flex-1">
                <input
                  type="number"
                  v-model="localFilters.maxPrice"
                  placeholder="Máximo"
                  class="w-full px-3 py-2 border rounded-lg"
                />
              </div>
            </div>
          </div>
  
          <!-- Fecha límite -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              Fecha límite
            </label>
            <input
              type="date"
              v-model="localFilters.endDate"
              class="w-full px-3 py-2 border rounded-lg"
            />
          </div>
        </div>
  
        <!-- Botones -->
        <div class="flex justify-end gap-4 mt-6">
          <button
            @click="$emit('close')"
            class="px-4 py-2 text-gray-600 hover:text-gray-800"
          >
            Cancelar
          </button>
          <button
            @click="applyFilters"
            class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700"
          >
            Aplicar Filtros
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue'
  
  export default {
    name: 'FilterModal',
    props: {
      filters: {
        type: Object,
        required: true
      }
    },
    emits: ['close', 'apply'],
    setup(props, { emit }) {
      const localFilters = ref({ ...props.filters })
  
      const applyFilters = () => {
        emit('apply', { ...localFilters.value })
      }
  
      return {
        localFilters,
        applyFilters
      }
    }
  }
  </script>