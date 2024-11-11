<template>
  <div :class="`${isDarkMode ? 'bg-[#242426] text-white' : 'bg-white'} p-6 rounded-lg shadow-lg mb-8`">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Renderizamos dinámicamente los campos del usuario -->
      <PersonalField
        v-for="(value, key) in userFields"
        :key="key"
        :label="formatLabel(key)"
        :type="getInputType(key)"
        v-model="user[key]"
        :placeholder="getPlaceholder(key)"
      />
    </div>
  </div>
</template>

<script setup>
import { useDarkMode } from '@/composables/useDarkMode';
import PersonalField from '@/Components/Profile/PersonalField.vue';
import { defineProps, computed } from 'vue';

const { isDarkMode } = useDarkMode();

// Define la prop `user`
const props = defineProps({
  user: {
    type: Object,
    default: () => ({
      name: '',
      email: '',
      phone: '',
      address: '',
      country: '',
    }),
  },
});

// Computed para obtener los campos del usuario dinámicamente
const userFields = computed(() => props.user);

// Función para formatear el label
const formatLabel = (key) => {
  switch (key) {
    case 'name':
      return 'Nombre Completo';
    case 'email':
      return 'Correo Electrónico';
    case 'phone':
      return 'Teléfono';
    case 'address':
      return 'Dirección';
    case 'country':
      return 'País';
    default:
      return key.charAt(0).toUpperCase() + key.slice(1);
  }
};

// Función para obtener el tipo de input
const getInputType = (key) => {
  switch (key) {
    case 'email':
      return 'email';
    case 'phone':
      return 'tel';
    default:
      return 'text';
  }
};

// Función para obtener el placeholder
const getPlaceholder = (key) => {
  switch (key) {
    case 'name':
      return 'Ingresa tu nombre';
    case 'email':
      return 'Ingresa tu correo';
    case 'phone':
      return 'Ingresa tu número de teléfono';
    case 'address':
      return 'Ingresa tu dirección';
    case 'country':
      return 'Ingresa tu país';
    default:
      return `Ingresa tu ${key}`;
  }
};
</script>

<style scoped>
/* Estilo adicional */
input:focus {
  outline: none;
  box-shadow: 0 0 10px rgba(0, 191, 255, 0.3);
}
</style>
