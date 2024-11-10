// resources/js/composables/useDarkMode.js
import { ref, watch } from 'vue';

// Estado global del modo oscuro
const isDarkMode = ref(localStorage.getItem('isDarkMode') === 'true');

// Función para alternar el modo oscuro
const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;
    localStorage.setItem('isDarkMode', isDarkMode.value);
};

// Sincronizar cambios en localStorage
watch(isDarkMode, (newValue) => {
    localStorage.setItem('isDarkMode', newValue);
});

// Exportar el composable
export function useDarkMode() {
    return { isDarkMode, toggleDarkMode };
}
