<template>
  <UserProfile :user="user" />
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import UserProfile from '@/Components/Profile/UserProfile.vue';

// Verificar si existe `auth` y `user` en los props de Inertia
const pageProps = usePage().props.value;
const user = pageProps?.auth?.user || {
  name: 'Usuario Desconocido',
  joinedDate: '2024-11-05',
  ticketsComprados: 4,
  ticketsObjetivo: 5,
  rifasParticipadas: 5,
  rifasGanadas: 1,
  nivel: 'Diamante',
};
</script>
