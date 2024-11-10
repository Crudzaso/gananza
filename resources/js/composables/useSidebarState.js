// useSidebarState.js
import { ref, watch } from 'vue';

// Estado global para saber si el sidebar está expandido
const isSidebarExpanded = ref(localStorage.getItem('isSidebarExpanded') === 'true');

// Función para alternar el estado del sidebar
export function useSidebarState() {
  const toggleSidebar = () => {
    isSidebarExpanded.value = !isSidebarExpanded.value;
    localStorage.setItem('isSidebarExpanded', isSidebarExpanded.value);
  };

  // Sincronizar el estado con `localStorage` cuando cambia
  watch(isSidebarExpanded, (newValue) => {
    localStorage.setItem('isSidebarExpanded', newValue);
  });

  return {
    isSidebarExpanded,
    toggleSidebar,
  };
}
