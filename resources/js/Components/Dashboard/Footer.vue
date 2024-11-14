<template>
  <footer :class="['footer-section py-8', theme.sectionBackground]">
    <div class="container mx-auto text-center space-y-6">
      <!-- Enlaces legales -->
      <div class="flex flex-col md:flex-row justify-center gap-4">
        <a href="/terms" :class="[theme.textLink]" class="hover:underline">
          Términos y Condiciones
        </a>
        <a href="/privacy" :class="[theme.textLink]" class="hover:underline">
          Política de Privacidad
        </a>
        <a href="/contact" :class="[theme.textLink]" class="hover:underline">
          Contáctanos
        </a>
        <a href="/about" :class="[theme.textLink]" class="hover:underline">
          Sobre Nosotros
        </a>
      </div>

      <!-- Información del proyecto -->
      <p :class="['text-sm', theme.textSecondary]">
        Proyecto Open Source - Contribuye en nuestro
        <a href="https://github.com/Crudzaso/gananza.git" target="_blank" :class="[theme.textLink]" class="hover:underline">
          Repositorio en GitHub
        </a>
      </p>

      <!-- Información adicional -->
      <p :class="['text-sm', theme.textSecondary]">
        © {{ new Date().getFullYear() }} Gananza - Laravel v (PHP v)
      </p>
    </div>
  </footer>
</template>

<script setup>
import { computed } from 'vue';
import { useDarkMode } from '@/composables/useDarkMode';

const { isDarkMode } = useDarkMode();

const theme = computed(() => ({
  sectionBackground: isDarkMode.value ? 'bg-[#1a1a1c]' : 'bg-[#F5F5F7] shadow-sm',
  textLink: isDarkMode.value ? 'text-blue-400' : 'text-blue-600',
  textSecondary: isDarkMode.value ? 'text-gray-400' : 'text-gray-700',
}));

// Props para obtener las versiones de Laravel y PHP
const props = defineProps({
  laravelVersion: String,
  phpVersion: String,
});
</script>

<style scoped>
.footer-section {
  transition: background-color 0.3s ease-in-out;
  border-radius: 12px;
}

a {
  transition: color 0.2s;
}

a:hover {
  color: #42a5f5;
}
</style>
