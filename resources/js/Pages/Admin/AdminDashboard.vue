<template>
    <div class="container mx-auto px-6 py-10">
        <!-- Botón de regreso al Dashboard -->
        <div class="mb-4">
            <Link
                href="/dashboard"
                class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-lg shadow-md hover:bg-gray-300 transition-colors duration-200"
            >
                <i class="fas fa-arrow-left mr-2"></i> Volver al Dashboard
            </Link>
        </div>

        <!-- Título del panel -->
        <h1 class="text-4xl font-bold text-gray-800 mb-10 text-center">Panel de Administración</h1>

        <!-- Enlaces de administración -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <Link href="/draws" class="admin-card bg-gradient-to-r from-blue-500 to-blue-700">
                <i class="fas fa-chart-line"></i>
                <span>Gestión de Sorteos</span>
            </Link>

            <Link href="/lotery" class="admin-card bg-gradient-to-r from-green-500 to-green-700">
                <i class="fas fa-ticket-alt"></i>
                <span>Gestión de Loterías</span>
            </Link>

            <Link href="/multimedia" class="admin-card bg-gradient-to-r from-yellow-500 to-yellow-700">
                <i class="fas fa-photo-video"></i>
                <span>Gestión de Multimedia</span>
            </Link>

            <Link href="/payment" class="admin-card bg-gradient-to-r from-red-500 to-red-700">
                <i class="fas fa-money-bill-wave"></i>
                <span>Gestión de Pagos</span>
            </Link>

            <Link href="/raffles" class="admin-card bg-gradient-to-r from-purple-500 to-purple-700">
                <i class="fas fa-gift"></i>
                <span>Gestión de Rifas</span>
            </Link>

            <Link href="/rewards" class="admin-card bg-gradient-to-r from-indigo-500 to-indigo-700">
                <i class="fas fa-award"></i>
                <span>Gestión de Recompensas</span>
            </Link>

            <Link href="/tickets" class="admin-card bg-gradient-to-r from-teal-500 to-teal-700">
                <i class="fas fa-tags"></i>
                <span>Gestión de Tickets</span>
            </Link>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
    components: {
        Link,
    },
};
</script>

<style scoped>
.container {
    max-width: 1200px;
}

.admin-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    color: white;
    border-radius: 1rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    font-size: 1.2rem;
    font-weight: bold;
    text-align: center;
}

.admin-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
}

.admin-card i {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    opacity: 0.9;
}
</style>
