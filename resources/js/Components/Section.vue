<template>
    <section class="mb-12">
      <h2 :class="['text-2xl font-semibold mb-4', theme.textPrimary]">{{ title }}</h2>
      <transition-group name="fade" tag="div" class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <RaffleCard
          v-for="raffle in items"
          :key="raffle.id"
          :raffle="raffle"
          class="hover:shadow-lg transition-shadow duration-300"
        />
      </transition-group>
      <div v-if="items.length === 0" :class="['text-center py-4', theme.textSecondary]">
        No hay rifas disponibles en esta categoría.
      </div>
    </section>
  </template>
  
  <script setup>
  import RaffleCard from './Dashboard/RaffleCard.vue';
  defineProps(['title', 'items', 'theme']);
  </script>
  
  <style scoped>
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.3s;
  }
  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }
  </style>
  