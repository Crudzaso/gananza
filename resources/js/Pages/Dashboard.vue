<template>
  <div class="d-flex flex-column flex-root">
    <div class="page d-flex flex-row flex-column-fluid">
      <div class="wrapper d-flex flex-column flex-row-fluid">
        <Navbar />
        <div
          class="content p-5"
          :style="[contentStyle]"
        >
          <HeroBanner />
          <ActiveRaffles />
          <LastChanceRaffles />
          <UserTestimonials />
          <OrganizerRegisterSection />
          <Footer :laravelVersion="laravelVersion" :phpVersion="phpVersion" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import Navbar from '../Components/Dashboard/NavBar.vue';
import HeroBanner from '../Components/Dashboard/HeroBanner.vue';
import ActiveRaffles from '../Components/Dashboard/ActiveRaffles.vue';
import LastChanceRaffles from '../Components/Dashboard/LastChanceRaffles.vue';
import { useDarkMode } from '@/composables/useDarkMode';
import { computed } from 'vue';
import UserTestimonials from '@/Components/Dashboard/UserTestimonials.vue';
import OrganizerRegisterSection from '@/Components/Dashboard/OrganizerRegisterSection.vue';
import Footer from '@/Components/Dashboard/Footer.vue';

const { isDarkMode } = useDarkMode();

// Computed para el estilo dinámico de la sección .content
const contentStyle = computed(() => ({
  backgroundColor: isDarkMode.value ? '#000000' : '#f5f7fa',
  color: isDarkMode.value ? '#ffffff' : '#212121', // Cambiar el color del texto también para mejor legibilidad
}));
</script>

<style scoped>
.wrapper {
  padding: 0;
}

.content {
  min-height: calc(100vh - 200px);
  margin-top: 0;
  transition: margin-left 0.3s ease, background-color 0.3s ease;
}
</style>
