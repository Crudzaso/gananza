<template>
  <header :style="{ background: theme.gradient, marginLeft: isSidebarExpanded ? '250px' : '100px' }" class="navbar p-4 border-b">
    <div class="container mx-auto flex justify-between items-center">
      <!-- Logo y Título -->
      <div class="flex items-center gap-4">
        <img :src="isDarkMode ? '/assets/media/auth/Logo-Gananza1.svg' : '/assets/media/auth/Logo-Gananza2.svg'"
             alt="Logo Gananza" class="h-10 logo" />
      </div>

      <!-- Búsqueda -->
      <div class="header-search hidden md:flex">
        <form class="search-form">
          <input
            type="text"
            class="search-input"
            placeholder="Buscar..."
            :style="{ background: theme.cardBackground, color: theme.textPrimary, borderColor: theme.border }"
          />
          <button type="submit" class="search-button">
            <img :src="isDarkMode ? '/assets/media/gananza/search-light.svg' : '/assets/media/gananza/search-dark.svg'" alt="Buscar" class="icon-img" />
          </button>
        </form>
      </div>

      <!-- Iconos y Botones -->
      <div class="flex items-center gap-4">
        <!-- Modo Oscuro -->
        <button @click="toggleDarkMode" class="btn-icon glow-effect" :style="{ background: theme.cardBackground }">
          <Sun v-if="isDarkMode" :size="24" :color="theme.emphasis" />
          <Moon v-else :size="24" :color="theme.primary" />
        </button>

        <!-- Notificaciones -->
        <a href="/helo">
          <button class="btn-icon glow-effect">
            <img :src="isDarkMode ? '/assets/media/gananza/notification-light.svg' : '/assets/media/gananza/notification-dark.svg'" alt="Notificaciones" class="icon-img" />
          </button>
        </a>

        <!-- Perfil de Usuario -->
        <a href="/profile">
          <button class="btn-icon glow-effect">
            <img :src="isDarkMode ? '/assets/media/gananza/user-light.svg' : '/assets/media/gananza/user-dark.svg'" alt="Perfil" class="icon-img" />
          </button>
        </a>
      </div>
    </div>
  </header>
</template>

<script setup>
import { Sun, Moon } from 'lucide-vue-next';
import { ref, computed } from 'vue';
import { useDarkMode } from '@/composables/useDarkMode';
import { useSidebarState } from '@/composables/useSidebarState';

const { isSidebarExpanded } = useSidebarState();

const { isDarkMode, toggleDarkMode } = useDarkMode();

// Computed para los colores del tema
const theme = computed(() => ({
  primary: isDarkMode.value ? '#42A5F5' : '#1565C0',
  textPrimary: isDarkMode.value ? '#E0E0E0' : '#212121',
  textSecondary: isDarkMode.value ? '#B0BEC5' : '#757575',
  cardBackground: isDarkMode.value ? '#1E1E1E' : '#FFFFFF',
  border: isDarkMode.value ? '#424242' : '#E0E0E0',
  gradient: isDarkMode.value
    ? 'linear-gradient(135deg, #1E1E1E 0%, #2A2A2A 100%)'
    : 'linear-gradient(135deg, #FFFFFF 0%, #F5F5F5 100%)',
  emphasis: isDarkMode.value ? '#FFCA28' : '#FFC107',
}));
</script>

<style scoped>
/* Estilo de Navbar */
.navbar {
  transition: margin-left 0.3s ease, background-color 0.3s, color 0.3s;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Logo */
.logo {
  transition: transform 0.2s;
}
.logo:hover {
  transform: scale(1.05);
}

/* Búsqueda */
.search-form {
  position: relative;
}
.search-input {
  width: 300px;
  padding: 10px 15px;
  border-radius: 25px;
  border: 1px solid;
  transition: all 0.3s;
}
.search-input:focus {
  outline: none;
  box-shadow: 0 0 10px rgba(0, 191, 255, 0.3);
}
.search-button {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  padding: 0;
  cursor: pointer;
}

/* Iconos y Botones */
.btn-icon {
  background-color: transparent;
  padding: 10px;
  border-radius: 50%;
  transition: transform 0.2s, box-shadow 0.2s;
  position: relative;
  overflow: hidden;
}
.btn-icon:hover {
  transform: scale(1.15);
  box-shadow: 0 8px 20px rgba(0, 191, 255, 0.4);
}

/* Efecto Glow */
.glow-effect {
  box-shadow: 0 0 8px rgba(255, 255, 255, 0.2);
}
.glow-effect:hover {
  box-shadow: 0 0 15px rgba(255, 255, 255, 0.4), 0 0 20px rgba(0, 191, 255, 0.5);
}

/* Icono */
.icon-img {
  width: 28px;
  height: 28px;
  transition: transform 0.3s;
}
.icon-img:hover {
  transform: rotate(10deg) scale(1.1);
}
</style>
