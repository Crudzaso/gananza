<template>
    <div class="container mx-auto px-6 py-10">
      <!-- Encabezado -->
      <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-extrabold text-gray-800">Crear Nuevo Usuario</h1>
        <button
          @click="goBack"
          class="px-6 py-2 bg-gray-600 text-white font-semibold rounded-lg shadow-md hover:bg-gray-700"
        >
          Volver
        </button>
      </div>
  
      <!-- Formulario de Creación -->
      <div class="bg-white shadow-lg rounded-lg p-6">
        <form @submit.prevent="submit" class="space-y-6">
          <!-- Campo Nombre -->
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input
              id="name"
              v-model="form.name"
              type="text"
              placeholder="Ingresa el nombre"
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
  
          <!-- Campo Apellido -->
          <div>
            <label for="lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
            <input
              id="lastname"
              v-model="form.lastname"
              type="text"
              placeholder="Ingresa el apellido"
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
  
          <!-- Campo Documento -->
          <div>
            <label for="document" class="block text-sm font-medium text-gray-700">Documento</label>
            <input
              id="document"
              v-model="form.document"
              type="text"
              placeholder="Ingresa el número de documento"
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
  
          <!-- Campo Tipo de Documento -->
          <div>
            <label for="document_type" class="block text-sm font-medium text-gray-700">Tipo de Documento</label>
            <select
              id="document_type"
              v-model="form.document_type"
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="" disabled>Selecciona el tipo de documento</option>
              <option value="CC">Cédula de Ciudadanía</option>
              <option value="TI">Tarjeta de Identidad</option>
              <option value="CE">Cédula de Extranjería</option>
              <option value="PAS">Pasaporte</option>
            </select>
          </div>
  
          <!-- Campo Número de Teléfono -->
          <div>
            <label for="phone_number" class="block text-sm font-medium text-gray-700">Número de Teléfono</label>
            <input
              id="phone_number"
              v-model="form.phone_number"
              type="text"
              placeholder="Ingresa el número de teléfono"
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
  
          <!-- Campo Email -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              placeholder="Ingresa el email"
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
  
          <!-- Campo Contraseña -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
            <input
              id="password"
              v-model="form.password"
              type="password"
              placeholder="Ingresa la contraseña"
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
  
          <!-- Botón Guardar -->
          <div class="flex justify-end">
            <button
              type="submit"
              class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700"
            >
              Guardar
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue';
  import { router } from '@inertiajs/vue3';
  
  export default {
    setup() {
      const form = ref({
        name: '',
        lastname: '',
        document: '',
        document_type: '',
        phone_number: '',
        email: '',
        password: '',
      });
  
      const submit = () => {
        router.post('/users', form.value);
      };
  
      const goBack = () => {
        router.visit('/users');
      };
  
      return { form, submit, goBack };
    },
  };
  </script>
  