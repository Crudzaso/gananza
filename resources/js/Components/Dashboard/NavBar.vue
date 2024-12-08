<template>
  <header :class="['navbar p-4 border-b', theme.backgroundGradient]">
    <div class="container mx-auto flex justify-between items-center">
      <div class="flex items-center gap-4">
        <img :src="isDarkMode ? '/assets/media/auth/Logo-Gananza1.svg' : '/assets/media/auth/Logo-Gananza2.svg'"
          alt="Logo Gananza" class="h-12 logo" />
      </div>
      <div class="flex items-center gap-2">
        <button @click="toggleDarkMode" class="btn-icon glow-effect" :style="{ background: theme.cardBackground }">
          <Sun v-if="isDarkMode" :size="20" :color="theme.emphasis" />
          <Moon v-else :size="20" :color="theme.primary" />
        </button>
        <button class="btn-icon glow-effect">
          <a :href="`/profile/${authUser.id}`">
            <img :src="isDarkMode ? '/assets/media/gananza/user-light.svg' : '/assets/media/gananza/user-dark.svg'"
              alt="Perfil" class="icon-img" />
          </a>
        </button>
        <button
          @click="handleExploreRaffles"
          :class="['hidden md:block font-semibold py-2 px-4 rounded-lg transition', theme.primaryButton]"
        >
          Organizar Rifas
        </button>
        <button v-if="isAdmin"
          @click="handleAdminPanel"
          :class="['hidden md:block font-semibold py-2 px-4 rounded-lg transition', theme.secondaryButton]"
        >
          Panel de Administrador
        </button>
        <button @click="logout" :class="['hidden md:block font-semibold py-2 px-4 rounded-lg transition', theme.secondaryButton]">
          Logout
        </button>
        <button class="menu-toggle btn-icon glow-effect" @click="toggleMenu">
          <img :src="isDarkMode ? '/assets/media/gananza/bars-light.svg' : '/assets/media/gananza/bars-dark.svg'"
            alt="Menú" class="icon-img" />
        </button>
      </div>
    </div>
    <nav :class="['nav-links', { 'open': isMenuOpen }]">
      <button class="close-btn" @click="toggleMenu" :style="{ color: theme.textPrimary }">✖</button>
      <h3 class="menu-title" :style="{ color: theme.textPrimary }">Navegación</h3>
      <a href="/profile" class="nav-link" :style="{ color: theme.textPrimary, borderColor: theme.border }">Perfil</a>
      <a @click.prevent="handleExploreRaffles" class="nav-link" :style="{ color: theme.textPrimary, borderColor: theme.border }">
        Organizar Rifas
      </a>
      <a v-if="isAdmin" @click.prevent="handleAdminPanel" class="nav-link" :style="{ color: theme.textPrimary, borderColor: theme.border }">
        Panel de Administrador
      </a>
      <a @click.prevent="logout" class="nav-link" :style="{ color: theme.textPrimary, borderColor: theme.border }">
        Logout
      </a>
    </nav>
  </header>
</template>

<script setup>
import { Sun, Moon } from 'lucide-vue-next';
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { useDarkMode } from '@/composables/useDarkMode';
import { usePage } from '@inertiajs/vue3';

const authUser = computed(() => usePage().props.auth.user);
const isAdmin = computed(() => authUser.value.roles && authUser.value.roles.includes('admin'));

const { isDarkMode, toggleDarkMode } = useDarkMode();
const isMenuOpen = ref(false);

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value;
};

const handleExploreRaffles = () => {
  window.location.href = '/raffles/admin/rifas';
};

const handleAdminPanel = () => {
  window.location.href = '/admin';
};

const logout = () => {
  router.post(route('logout'), {}, {
    onFinish: () => {
      window.location.href = '/login';
    },
  });
};

const theme = computed(() => ({
  backgroundGradient: isDarkMode.value
    ? 'bg-[#1a1a1c] shadow-lg'
    : 'bg-[#F5F5F7] shadow-sm',
  textPrimary: isDarkMode.value ? 'text-white' : 'text-gray-900',
  textSecondary: isDarkMode.value ? 'text-gray-300' : 'text-gray-700',
  primaryButton: isDarkMode.value
    ? 'bg-blue-700 text-white hover:bg-blue-800'
    : 'bg-blue-600 text-white hover:bg-blue-700',
  secondaryButton: isDarkMode.value
    ? 'bg-red-700 text-white hover:bg-red-800'
    : 'bg-red-600 text-white hover:bg-red-700',
  cardBackground: isDarkMode.value ? '#242526' : '#FFFFFF',
  navBackground: isDarkMode.value ? '#1E1E1E' : '#FFFFFF',
  navShadow: isDarkMode.value ? '0 8px 20px rgba(0, 0, 0, 0.8)' : '0 8px 20px rgba(0, 191, 255, 0.2)',
  border: isDarkMode.value ? '#424242' : '#E0E0E0',
  gradient: isDarkMode.value ? 'linear-gradient(135deg, #1E1E1E 0%, #2A2A2A 100%)' : 'linear-gradient(135deg, #FFFFFF 0%, #F5F5F5 100%)',
  emphasis: isDarkMode.value ? '#FFCA28' : '#FFC107',
}));
</script>

<style scoped>
.navbar {
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  z-index: 1001;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo {
  transition: transform 0.2s;
}

.logo:hover {
  transform: scale(1.05);
}

.nav-links {
  display: none;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 2rem;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  padding: 20px;
  background: rgba(0, 0, 0, 0.8);
  backdrop-filter: blur(10px);
  transition: all 0.3s ease;
  z-index: 1002;
}

.nav-links.open {
  display: flex;
  animation: slideIn 0.3s ease-out forwards;
}

.close-btn {
  align-self: flex-end;
  font-size: 2rem;
  font-weight: bold;
  background: none;
  border: none;
  cursor: pointer;
  margin-bottom: 20px;
  transition: transform 0.2s;
}

.close-btn:hover {
  transform: scale(1.1) rotate(90deg);
}

.menu-title {
  font-size: 1.5rem;
  font-weight: bold;
  margin-bottom: 20px;
  text-align: center;
  color: #fff;
}

.nav-link {
  text-decoration: none;
  font-size: 1.2rem;
  padding: 15px 20px;
  border-radius: 10px;
  border: 1px solid;
  width: 80%;
  text-align: center;
  transition: color 0.2s, background-color 0.3s, transform 0.2s;
  color: #fff;
  border-color: #fff;
}

.nav-link:hover {
  color: var(--emphasis);
  background-color: rgba(255, 255, 255, 0.1);
  transform: scale(1.05);
}

@media (max-width: 768px) {
  .nav-links {
    padding: 40px 20px;
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

  .menu-toggle {
    display: block;
  }
}

@media (min-width: 769px) {
  .menu-toggle {
    display: none;
  }
}

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

.icon-img {
  width: 24px;
  height: 24px;
  transition: transform 0.3s;
}

.icon-img:hover {
  transform: rotate(10deg) scale(1.1);
}

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