<template>
  <div class="mb-4">
    <label :class="`${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`" class="block mb-1 font-semibold">
      {{ label }}
    </label>
    <input
      :type="type"
      v-model="localValue"
      :placeholder="placeholder"
      class="mt-1 block w-full rounded-md border p-2"
      :class="`${isDarkMode ? 'bg-[#1a1a1c] border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'}`"
    />
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { useDarkMode } from '@/composables/useDarkMode';

// Definir las props usando defineProps
const props = defineProps({
  label: {
    type: String,
    required: true,
  },
  value: {
    type: String,
    default: '',
  },
  type: {
    type: String,
    default: 'text',
  },
  placeholder: {
    type: String,
    default: '',
  },
});

// Definir emit para permitir la comunicación con el padre
const emit = defineEmits(['update:value']);
const { isDarkMode } = useDarkMode();

// Crear una referencia local para manejar el valor del input
const localValue = ref(props.value);

// Sincronizar los cambios del input con el componente padre
watch(localValue, (newValue) => {
  emit('update:value', newValue);
});

// Actualizar el valor local si cambia la prop `value` desde el padre
watch(
  () => props.value,
  (newValue) => {
    localValue.value = newValue;
  }
);
</script>

<style scoped>
/* Estilos adicionales */
input:focus {
  outline: none;
  box-shadow: 0 0 10px rgba(0, 191, 255, 0.3);
}
</style>
