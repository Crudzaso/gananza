<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import SearchBar from './SearchBar.vue';
import ButtonHeader1 from './ButtonHeader1.vue';
import ButtonHeader2 from './ButtonHeader2.vue';

const isScrolled = ref(false);

const handleScroll = () => {
  isScrolled.value = window.scrollY > 40;
};

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
});

onBeforeUnmount(() => {
  window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
  <header :class="['header', { 'header-scrolled': isScrolled }]">
    <div class="title">
      <h1>Dashboard</h1>
      <p>Create a store with #YDR-124-346 code</p>
    </div>

    <div class="container-btns">
      <SearchBar/>
      <ButtonHeader1/>
      <ButtonHeader2/>
    </div>
  </header>
</template>

<script>
export default {
  name: 'Header',
}
</script>

<style scoped>
.header {
  position: fixed;
  top: 0;
  left:13.4%;
  width: 87%;
  background-color: white !important;
  border: 1px solid #ffdd00 ;
  border-left: none ;
  color: white;
  padding: 20px;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  z-index: 1000;
  transition: height 0.2s ease; /* Transición suave para el cambio de altura */
  height: 30%; /* Altura inicial */
}

.header-scrolled {
  height: 19%; /* Altura reducida cuando se hace scroll */
}

.title {
  margin-left: 18%;
  color: black;
}

.title h1 {
  margin: 0;
  font-size: 24px;
}

.title p {
  margin: 0;
  font-size: 12px;
  color: #c0c0d5;
}

.container-btns {
  display: flex;
  width: 40%;
  height: 6vh;
  margin-left: 20%;
}
</style>
