<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
      <h2 class="text-2xl font-bold text-center mb-6">Verificación de Acceso</h2>
      
      <form @submit.prevent="verifyPassword">
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">
            Por favor, ingrese su contraseña para acceder al panel de administración
          </label>
          <input
            type="password"
            v-model="form.password"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            :class="{ 'border-red-500': form.errors.password }"
            ref="passwordInput"
            @keydown.enter="verifyPassword"
          />
          <p v-if="form.errors.password" class="text-red-500 text-xs mt-1">
            {{ form.errors.password }}
          </p>
        </div>

        <div class="flex items-center justify-end">
          <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
            :disabled="form.processing"
          >
            Verificar
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'

const passwordInput = ref(null)
const form = useForm({
  password: '',
})

onMounted(() => {
  passwordInput.value?.focus()
})

const verifyPassword = async () => {
  try {
    const response = await axios.post(route('admin.verify-password.check'), {
      password: form.password
    })
    
    if (response.data.success) {
      window.location.href = response.data.redirect || '/admin'
    }
  } catch (error) {
    if (error.response?.data?.message) {
      form.errors.password = error.response.data.message
    }
    form.password = ''
    passwordInput.value?.focus()
  }
}
</script>