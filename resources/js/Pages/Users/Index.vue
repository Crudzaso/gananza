<template>
    <div class="container mx-auto px-6 py-10">
      <!-- Encabezado -->
      <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-extrabold text-gray-800">Gestión de Usuarios</h1>
        <div class="flex gap-4">
          <!-- Botón Crear Usuario -->
          <button
            @click="goToCreateUser"
            class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700"
          >
            Nuevo Usuario
          </button>
        </div>
      </div>
  
      <!-- Tabla de Usuarios -->
      <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-blue-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nombre</th>
              <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Email</th>
              <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Acciones</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-100">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ user.name }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ user.email }}</td>
              <td class="px-6 py-4 whitespace-nowrap flex items-center gap-3">
                <!-- Botón Editar -->
                <button
                @click="editUser(user)"
                class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600"
              >
                Editar
              </button>
                <!-- Botón Eliminar -->
                <button
                  @click="deleteUser(user.id)"
                  class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-red-700"
                >
                  Eliminar
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
  
      <!-- Paginación -->
      <div class="flex justify-between items-center mt-6">
        <p class="text-sm text-gray-600">
          Mostrando página {{ users.current_page }} de {{ users.last_page }}.
        </p>
        <div class="flex gap-2">
          <button
            @click="goToPreviousPage"
            :disabled="!users.prev_page_url"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg shadow hover:bg-gray-400 disabled:opacity-50"
          >
            Anterior
          </button>
          <button
            @click="goToNextPage"
            :disabled="!users.next_page_url"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg shadow hover:bg-gray-400 disabled:opacity-50"
          >
            Siguiente
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { router } from '@inertiajs/vue3';
  
  export default {
    props: {
      users: Object,
    },
    methods: {
      goToCreateUser() {
        router.visit('/users/create');
      },
      editUser(user) {
      router.visit(`/users/${user.id}/edit`);
    },
      deleteUser(id) {
        if (confirm('¿Estás seguro de eliminar este usuario?')) {
          router.delete(`/users/${id}`);
        }
      },
      goToPreviousPage() {
        if (this.users.prev_page_url) {
          router.visit(this.users.prev_page_url);
        }
      },
      goToNextPage() {
        if (this.users.next_page_url) {
          router.visit(this.users.next_page_url);
        }
      },
    },
  };
  </script>
  