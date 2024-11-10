<template>
  <aside :class="['aside-container', isSidebarExpanded ? 'expanded' : 'collapsed']" :style="{ background: theme.cardBackground }">
    <!-- Logo (Botón para expandir/contraer) -->
    <div class="aside-logo" @click="toggleSidebar">
      <img
        :src="isDarkMode ? '/assets/media/auth/Letra-Gananza.svg' : '/assets/media/auth/Letra-Gananza.svg'"
        alt="Logo"
        class="logo-image"
      />
    </div>

    <!-- Menú de Navegación -->
    <nav class="aside-nav">
      <ul class="ul-navigate">
        <li v-for="item in menuItems" :key="item.text" class="nav-item">
          <a :href="item.route" class="nav-link icon-button">
            <div class="icon-container">
              <img :src="isDarkMode ? item.iconDark : item.iconLight" alt="" class="nav-icon" />
            </div>
            <span v-if="isSidebarExpanded" :class="['link-text', isDarkMode ? 'text-dark-mode' : 'text-light-mode']">{{ item.text }}</span>
          </a>
        </li>
      </ul>
    </nav>

    <!-- Botón de Cerrar Sesión -->
    <button @click="handleLogout" class="logout-link icon-button">
      <div class="icon-container">
        <img :src="isDarkMode ? '/assets/media/gananza/logout-light.svg' : '/assets/media/gananza/logout-dark.svg'" alt="Cerrar Sesión" class="nav-icon" />
      </div>
    </button>

    <ConfirmationModal />
  </aside>
</template>

<script setup>
import { computed } from 'vue';
import { useDarkMode } from '@/composables/useDarkMode';
import { useConfirmationModal } from '@/composables/useConfirmationModal';
import { router } from '@inertiajs/vue3';
import { useSidebarState } from '@/composables/useSidebarState';
import ConfirmationModal from '@/Components/Dashboard/ConfirmationModal.vue';

const { openModal } = useConfirmationModal();
const { isDarkMode } = useDarkMode();
const { isSidebarExpanded, toggleSidebar } = useSidebarState();

const theme = computed(() => ({
  primary: isDarkMode.value ? '#42A5F5' : '#1565C0',
  textPrimary: isDarkMode.value ? '#E0E0E0' : '#212121',
  cardBackground: isDarkMode.value ? '#1E1E1E' : '#FFFFFF',
  emphasis: isDarkMode.value ? '#FFCA28' : '#FFC107',
}));

const menuItems = [
  { text: "Inicio", route: "dashboard", iconLight: "/assets/media/gananza/home-dark.svg", iconDark: "/assets/media/gananza/home-light.svg" },
  { text: "Documentos", route: "/documents", iconLight: "/assets/media/gananza/document-dark.svg", iconDark: "/assets/media/gananza/document-light.svg" },
  { text: "Soporte", route: "/support", iconLight: "/assets/media/gananza/support-dark.svg", iconDark: "/assets/media/gananza/support-light.svg" },
  { text: "Panel", route: "/admin", iconLight: "/assets/media/gananza/organizer-dark.svg", iconDark: "/assets/media/gananza/organizer-light.svg" },
  { text: "Configuración", route: "/security", iconLight: "/assets/media/gananza/setting-dark.svg", iconDark: "/assets/media/gananza/setting-light.svg" },
];

const handleLogout = () => {
  openModal("¿Estás seguro de que deseas cerrar sesión?", () => {
    router.post('/logout');
  });
};
</script>



<style scoped>
/* Botones e Iconos */
/* Estilo del Aside */
.aside-container {
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
  padding: 20px 0;
  transition: width 0.3s, background-color 0.3s;
  z-index: 1000;
}

.collapsed {
  width: 100px;
}

.expanded {
  width: 250px;
}

/* Logo */
.aside-logo {
  margin-bottom: 20px;
  cursor: pointer;
}

.logo-image {
  width: 40px;
  height: auto;
  transition: transform 0.2s;
}

.logo-image:hover {
  transform: scale(1.05);
}

/* Menú de Navegación */
.aside-nav {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  width: 100%;
}

.ul-navigate {
  list-style: none;
  padding: 0;
  margin: 0;
  width: 100%;
}

.nav-item {
  margin-left: 15px;
  width: 100%;
}

.nav-link {
  display: flex;
  align-items: center;
  padding: 10px;
  width: 70%;
  text-decoration: none;
  color: inherit;
  transition: all 0.3s;
}

/* Efectos de Hover para Sidebar Pequeño */
.collapsed .icon-button:hover {
  transform: scale(1.1);
  box-shadow: 0 4px 15px rgba(0, 191, 255, 0.2);
  background-color: rgba(0, 191, 255, 0.08);
}

/* Efectos de Hover para Sidebar Expandido */
.expanded .icon-button:hover {
  transform: scale(1.05);
  box-shadow: 0 6px 20px rgba(0, 191, 255, 0.3);
  background-color: rgba(0, 191, 255, 0.15);
}

/* Contenedor de Iconos */
.icon-container {
  width: 48px;
  height: 48px;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 50%;
  transition: background-color 0.2s;
}

.icon-container:hover {
  background-color: rgba(0, 191, 255, 0.1);
}

/* Iconos como Imágenes */
.nav-icon {
  width: 28px;
  height: 28px;
  transition: transform 0.2s;
}

.nav-icon:hover {
  transform: scale(1.1);
}

/* Estilos para los textos de los enlaces */
.link-text {
  margin-left: 15px;
  font-size: 1em;
  transition: opacity 0.3s;
  opacity: 1;
}

/* Botón de Cerrar Sesión */
.logout-link {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 70%;
  text-align: left;
  padding: 10px;
}

/* Hover del botón de cerrar sesión en sidebar pequeño */
.collapsed .logout-link:hover {
  background-color: rgba(255, 0, 0, 0.2);
  transform: scale(1.1);
  box-shadow: 0 0 10px rgba(255, 0, 0, 0.3);
}

/* Hover del botón de cerrar sesión en sidebar expandido */
.expanded .logout-link:hover {
  background-color: rgba(255, 0, 0, 0.3);
  transform: scale(1.05);
  box-shadow: 0 0 15px rgba(255, 0, 0, 0.4);
}

/* Colores del texto para los enlaces */
.text-light-mode {
  color: #212121; /* Color oscuro para modo claro */
}

.text-dark-mode {
  color: #E0E0E0; /* Color claro para modo oscuro */
}

</style>
