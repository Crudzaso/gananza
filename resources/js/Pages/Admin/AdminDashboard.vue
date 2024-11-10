<template>
    <div :class="['admin-container', isDarkMode ? 'bg-gray-900' : 'bg-white']">
        <!-- Botón de regreso al Dashboard -->
        <div class="mb-6">
            <Link
                href="/dashboard"
                class="inline-flex items-center px-5 py-3 rounded-lg shadow hover:shadow-lg transition-all duration-300"
                :class="isDarkMode ? 'bg-gray-800 text-white hover:bg-gray-700' : 'bg-gray-200 text-gray-800 hover:bg-gray-300'"
            >
                <i class="fas fa-arrow-left mr-3"></i> Volver al Dashboard
            </Link>
        </div>

        <!-- Título del panel -->
        <h1 :class="['text-4xl font-bold mb-10 text-center', isDarkMode ? 'text-white' : 'text-gray-800']">
            Panel de Administración
        </h1>

        <!-- Enlaces de administración -->
        <div class="admin-grid">
            <AdminCard href="/draws" icon="fa-chart-line" title="Gestión de Sorteos" color="blue" />
            <AdminCard href="/lotery" icon="fa-ticket-alt" title="Gestión de Loterías" color="green" />
            <AdminCard href="/multimedia" icon="fa-photo-video" title="Gestión de Multimedia" color="yellow" />
            <AdminCard href="/payment" icon="fa-money-bill-wave" title="Gestión de Pagos" color="red" />
            <AdminCard href="/raffles" icon="fa-gift" title="Gestión de Rifas" color="purple" />
            <AdminCard href="/rewards" icon="fa-award" title="Gestión de Recompensas" color="indigo" />
            <AdminCard href="/tickets" icon="fa-tags" title="Gestión de Tickets" color="teal" />
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import AdminCard from '../../Components/Admin-panel/AdminCard.vue';
import { useDarkMode } from '@/composables/useDarkMode';

const { isDarkMode } = useDarkMode();
</script>

<style scoped>
/* Hacer que el contenedor ocupe toda la pantalla */
.admin-container {
    width: 100vw;
    height: 100vh;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: start;
    overflow: auto;
}

/* Grid que ocupa todo el espacio disponible */
.admin-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    width: 100%;
    max-width: 1200px;
}

/* Botones clicables */
.admin-card {
    position: relative;
    z-index: 1;
    cursor: pointer;
}
</style>
