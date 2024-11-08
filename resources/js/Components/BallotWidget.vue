<template>
  <div class="ballot-widget">
    <div 
      v-for="(digit, index) in digits" 
      :key="index" 
      class="ball-container" 
      :style="{ animationDelay: `${index * 0.2}s` }"
    >
      {{ digit }}
    </div>
    <button @click="generateRandomNumber">Generar Número</button>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const digits = ref([0, 0, 0, 0]); // Array para almacenar los números de cada "bola"

function generateRandomNumber() {
  digits.value = Array.from({ length: 4 }, () => Math.floor(Math.random() * 10)); // Genera números aleatorios entre 0 y 9 para cada dígito
}
</script>

<style scoped>
.ballot-widget {
  display: flex;
  gap: 15px;
  background-color: rgb(0, 0, 0);
  border-radius: 20px;
  justify-content: center;
  align-items: center;
  margin-top: -7%;
}

.ball-container {
  width: 60px;
  height: 60px;
 
  background: #ffdd00; /* Color de fondo */
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 24px;
  color: white;
  font-weight: bold;
  animation: spin 1s ease-in-out;
}

/* Animación para simular la rotación */
@keyframes spin {
  0% { transform: rotateX(0deg); }
  100% { transform: rotateX(360deg); }
}

button {
  margin-top: 20px;
  padding: 10px 20px;
  background-color: #ffdd00;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
}

button:hover {
  background-color: #ffdd00;
}
</style>
