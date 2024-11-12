<template>
  <header :style="{ background: theme.gradient }" class="navbar p-4 border-b">
    <div class="container mx-auto flex justify-between items-center">
      <!-- Logo -->
      <div class="flex items-center gap-4">
        <img :src="isDarkMode ? '/assets/media/auth/Logo-Gananza1.svg' : '/assets/media/auth/Logo-Gananza2.svg'"
          alt="Logo Gananza" class="h-8 logo" />
      </div>

      <!-- Menú Hamburguesa para móvil -->
      <button class="menu-toggle md:hidden btn-icon glow-effect" @click="toggleMenu">
        <img :src="isDarkMode ? '/assets/media/gananza/bars-light.svg' : '/assets/media/gananza/bars-dark.svg'"
          alt="Menú" class="icon-img" />
      </button>

      <!-- Búsqueda -->
      <div class="header-search hidden md:flex">
        <form class="search-form">
          <input type="text" class="search-input" placeholder="Buscar..."
            :style="{ background: theme.cardBackground, color: theme.textPrimary, borderColor: theme.border }" />
          <button type="submit" class="search-button">
            <img :src="isDarkMode ? '/assets/media/gananza/search-light.svg' : '/assets/media/gananza/search-dark.svg'"
              alt="Buscar" class="icon-img" />
          </button>
        </form>
      </div>

      <!-- Links de Navegación -->
      <nav :class="['nav-links', { 'open': isMenuOpen }]"
        :style="{ background: theme.navBackground, boxShadow: theme.navShadow }">
        <!-- Botón para cerrar el menú -->
        <button class="close-btn" @click="toggleMenu" :style="{ color: theme.textPrimary }">✖</button>
        <h3 class="menu-title" :style="{ color: theme.textPrimary }">Navegación</h3>
        <a href="/profile" class="nav-link" :style="{ color: theme.textPrimary, borderColor: theme.border }">Profile</a>
        <a href="/admin" class="nav-link" :style="{ color: theme.textPrimary, borderColor: theme.border }">Panel de
          Administrador</a>
        <a href="/settings" class="nav-link"
          :style="{ color: theme.textPrimary, borderColor: theme.border }">Settings</a>
        <a href="/raffles" class="nav-link" :style="{ color: theme.textPrimary, borderColor: theme.border }">Rifas</a>
        <a href="/points" class="nav-link" :style="{ color: theme.textPrimary, borderColor: theme.border }">Puntos</a>
        <a @click.prevent="logout" class="nav-link logout-link"
          :style="{ color: theme.textPrimary, borderColor: theme.border, cursor: 'pointer', zIndex: 1000 }">
          Logout
        </a>
      </nav>
      <!-- Iconos y Botones -->
      <div class="flex items-center gap-3">
        <button @click="toggleDarkMode" class="btn-icon glow-effect" :style="{ background: theme.cardBackground }">
          <Sun v-if="isDarkMode" :size="20" :color="theme.emphasis" />
          <Moon v-else :size="20" :color="theme.primary" />
        </button>

        <button class="btn-icon glow-effect">
          <img
            :src="isDarkMode ? '/assets/media/gananza/notification-light.svg' : '/assets/media/gananza/notification-dark.svg'"
            alt="Notificaciones" class="icon-img" />
        </button>

        <button class="btn-icon glow-effect">
          <a :href="`/profile/${authUser.id}`">
            <img :src="isDarkMode ? '/assets/media/gananza/user-light.svg' : '/assets/media/gananza/user-dark.svg'"
              alt="Perfil" class="icon-img" />
          </a>
        </button>
      </div>
    </div>
  </header>
</template>

<script setup>
import { Sun, Moon } from 'lucide-vue-next';
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { useDarkMode } from '@/composables/useDarkMode';
import { usePage } from '@inertiajs/vue3';


const authUser = computed(() => usePage().props.auth.user);

const { isDarkMode, toggleDarkMode } = useDarkMode();
const isMenuOpen = ref(false);

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value;
};

const theme = computed(() => ({
  primary: isDarkMode.value ? '#42A5F5' : '#1565C0',
  textPrimary: isDarkMode.value ? '#E0E0E0' : '#212121',
  textSecondary: isDarkMode.value ? '#B0BEC5' : '#757575',
  cardBackground: isDarkMode.value ? '#242526' : '#FFFFFF',
  navBackground: isDarkMode.value ? '#1E1E1E' : '#FFFFFF',
  navShadow: isDarkMode.value ? '0 8px 20px rgba(0, 0, 0, 0.8)' : '0 8px 20px rgba(0, 191, 255, 0.2)',
  border: isDarkMode.value ? '#424242' : '#E0E0E0',
  gradient: isDarkMode.value ? 'linear-gradient(135deg, #1E1E1E 0%, #2A2A2A 100%)' : 'linear-gradient(135deg, #FFFFFF 0%, #F5F5F5 100%)',
  emphasis: isDarkMode.value ? '#FFCA28' : '#FFC107',
}));

const logout = () => {
  console.log("Logout clickeado"); // Verificar si el clic está funcionando
  router.post(route('logout'), {}, {
    onFinish: () => {
      window.location.href = '/login';
    },
  });
};
</script>

<style scoped>
/* Navbar */
.navbar {
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  z-index: 1001;
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
  width: 250px;
  padding: 8px 12px;
  border-radius: 20px;
  border: 1px solid;
  transition: all 0.3s;
}

.search-input:focus {
  outline: none;
  box-shadow: 0 0 10px rgba(0, 191, 255, 0.3);
}

.search-button {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
}

/* Menú de Navegación */
.nav-links {
  display: none;
  flex-direction: column;
  align-items: center;
  gap: 1.5rem;
  position: absolute;
  top: 60px;
  right: 10px;
  padding: 20px;
  border-radius: 15px;
  width: 350px;
  height: 600px;
  transition: all 0.3s ease;
  z-index: 1002;
}

.nav-links.open {
  display: flex;
  animation: slideIn 0.3s ease-out forwards;
}

/* Botón para cerrar el menú */
.close-btn {
  align-self: flex-end;
  font-size: 1.8rem;
  font-weight: bold;
  background: none;
  border: none;
  cursor: pointer;
  margin-bottom: 15px;
  transition: transform 0.2s;
}

.close-btn:hover {
  transform: scale(1.1) rotate(90deg);
}

/* Título del Menú */
.menu-title {
  font-size: 1.2rem;
  font-weight: bold;
  margin-bottom: 20px;
  text-align: center;
}

/* Enlaces de Navegación */
.nav-link {
  text-decoration: none;
  font-size: 1.1rem;
  padding: 10px 15px;
  border-radius: 10px;
  border: 1px solid;
  width: 100%;
  text-align: center;
  transition: color 0.2s, background-color 0.3s, transform 0.2s;
}

.nav-link:hover {
  color: var(--emphasis);
  background-color: rgba(0, 191, 255, 0.1);
  transform: scale(1.05);
}

/* Media Query para pantallas pequeñas */
@media (max-width: 768px) {
  .nav-links {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    padding: 40px 20px;
    border-radius: 0;
    justify-content: center;
    align-items: center;
    overflow-y: auto;
  }

  .close-btn {
    position: absolute;
    top: 20px;
    right: 20px;
  }

  .nav-link {
    font-size: 1.3rem;
    padding: 20px;
  }
}

/* Animaciones */
@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Menú Hamburguesa */
.menu-toggle {
  display: block;
}

/* Iconos */
.icon-img {
  width: 24px;
  height: 24px;
  transition: transform 0.3s;
}

.icon-img:hover {
  transform: rotate(10deg) scale(1.1);
}

/* Botones */
.btn-icon {
  padding: 8px;
  border-radius: 50%;
  transition: transform 0.2s, box-shadow 0.2s;
}

.btn-icon:hover {
  transform: scale(1.1);
  box-shadow: 0 4px 12px rgba(0, 191, 255, 0.4);
}

.logout-link {
  display: block;
  position: relative;
  z-index: 1000;
  cursor: pointer;
  padding: 10px;
  text-decoration: none;
}
</style>
