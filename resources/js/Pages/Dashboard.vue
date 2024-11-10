<template>
  <div class="d-flex flex-column flex-root">
    <div class="page d-flex flex-row flex-column-fluid">
      <Aside />
      <div class="wrapper d-flex flex-column flex-row-fluid">
        <Navbar />
        <div class="content p-5" :style="{ marginLeft: isSidebarExpanded ? '250px' : '100px' }">
          <h2>Hola bebe</h2>
        </div>
        <Footer />
      </div>
    </div>
  </div>
</template>

<script setup>
import Navbar from '../Components/Dashboard/NavBar.vue';
import Aside from '../Components/Dashboard/Aside.vue';
import Footer from '../Components/Dashboard/Footer.vue';
import { useSidebarState } from '@/composables/useSidebarState';

const { isSidebarExpanded } = useSidebarState();
</script>

<style scoped>
.wrapper {
  padding: 0;
}

.content {
  background-color: #ffffff;
  min-height: calc(100vh - 200px);
  margin-top: 0px;
  transition: margin-left 0.3s ease; /* Transición suave para el cambio de margen */
}
</style>
