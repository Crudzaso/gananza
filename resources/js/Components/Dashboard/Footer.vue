<template>
  <footer
    :style="{
      background: theme.gradient,
      color: theme.textPrimary,
      marginLeft: isSidebarExpanded ? '250px' : '100px',
    }"
    class="footer-container"
  >
    <div class="footer-links">
      <Link href="/terms" class="footer-link">Términos y Condiciones</Link>
      <Link href="/privacy" class="footer-link">Política de Privacidad</Link>
      <Link href="https://github.com/Crudzaso/gananza.git" target="_blank" class="footer-link">Repositorio en GitHub</Link>
      <Link href="/contact" class="footer-link">Contáctanos</Link>
      <Link href="/about" class="footer-link">Sobre Nosotros</Link>
    </div>
    <div class="footer-bottom">
      <p class="footer-text">&copy; 2024 Gananza. Laravel v. Todos los derechos reservados.</p>
    </div>
  </footer>
</template>

<script setup>
import { computed } from 'vue';
import { useDarkMode } from '@/composables/useDarkMode';
import { useSidebarState } from '@/composables/useSidebarState';
import { Link } from '@inertiajs/vue3';

const { isDarkMode } = useDarkMode();
const { isSidebarExpanded } = useSidebarState();

const theme = computed(() => ({
  primary: isDarkMode.value ? '#42A5F5' : '#1565C0',
  textPrimary: isDarkMode.value ? '#E0E0E0' : '#212121',
  gradient: isDarkMode.value
    ? 'linear-gradient(135deg, #1E1E1E 0%, #2A2A2A 100%)'
    : 'linear-gradient(135deg, #FFFFFF 0%, #F5F5F5 100%)',
}));
</script>


<style scoped>
/* Estilos del Sticky Footer */
.footer-container {
  padding: 20px 0;
  display: flex;
  flex-direction: column;
  align-items: center;
  transition: background-color 0.3s, margin-left 0.3s;
  position: fixed;
  bottom: 0;
  left: 0;
  width: calc(100% - 100px); /* Se ajustará dinámicamente */
  box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
}

.footer-links {
  display: flex;
  gap: 30px;
  justify-content: center;
  flex-wrap: wrap;
}

.footer-link {
  color: inherit;
  text-decoration: none;
  font-size: 0.95em;
  transition: color 0.3s;
}

.footer-link:hover {
  color: #ffffff;
}

.footer-bottom {
  margin-top: 10px;
  text-align: center;
  border-top: 1px solid;
  padding-top: 10px;
  font-size: 0.85em;
}

.footer-text {
  color: inherit;
}

</style>
