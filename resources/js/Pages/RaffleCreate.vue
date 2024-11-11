<template>
  <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Crear nueva rifa</h2>
    
    <!-- Alert para errores -->
    <div v-if="error" class="mb-4 p-4 bg-red-100 text-red-700 rounded">
      {{ error }}
    </div>

    <form @submit.prevent="submitForm">
      <!-- Nombre de la rifa -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700" for="name">Nombre de la rifa</label>
        <input
          type="text"
          v-model="form.name"
          id="name"
          class="w-full mt-1 p-2 border border-gray-300 rounded"
          required
        />
      </div>

      <!-- Lotería -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700" for="lottery_id">Lotería</label>
        <select 
          v-model="form.lottery_id" 
          id="lottery_id" 
          class="w-full mt-1 p-2 border border-gray-300 rounded"
          required
        >
          <option value="">Seleccione una lotería</option>
          <option v-for="lottery in lotteries" :key="lottery.id" :value="lottery.id">
            {{ lottery.name }}
          </option>
        </select>
      </div>

      <!-- Precio del boleto -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700" for="ticket_price">Precio del boleto</label>
        <input
          type="number"
          v-model.number="form.ticket_price"
          id="ticket_price"
          class="w-full mt-1 p-2 border border-gray-300 rounded"
          step="0.01"
          min="0"
          required
        />
      </div>

      <!-- Total de boletos -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700" for="total_tickets">Total de boletos</label>
        <input
          type="number"
          v-model.number="form.total_tickets"
          id="total_tickets"
          class="w-full mt-1 p-2 border border-gray-300 rounded"
          min="1"
          required
        />
      </div>

      <!-- Ganancias totales -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700" for="total_revenue">Total de ganancias</label>
        <input
          type="text"
          :value="totalRevenue"
          id="total_revenue"
          class="w-full mt-1 p-2 border border-gray-300 rounded bg-gray-100"
          readonly
        />
      </div>

      <!-- Descripción -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700" for="description">Descripción</label>
        <textarea
          v-model="form.description"
          id="description"
          class="w-full mt-1 p-2 border border-gray-300 rounded"
          rows="4"
        ></textarea>
      </div>

      <!-- Fecha de inicio -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700" for="start_date">Fecha de inicio</label>
        <input
          type="datetime-local"
          v-model="form.start_date"
          id="start_date"
          class="w-full mt-1 p-2 border border-gray-300 rounded"
          required
        />
      </div>

      <!-- Fecha de fin -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700" for="end_date">Fecha de fin</label>
        <input
          type="datetime-local"
          v-model="form.end_date"
          id="end_date"
          class="w-full mt-1 p-2 border border-gray-300 rounded"
          required
        />
      </div>

      <!-- Botón de envío -->
      <button
        type="submit"
        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded"
        :disabled="isLoading"
      >
        {{ isLoading ? 'Creando...' : 'Crear rifa' }}
      </button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      form: {
        name:"",
        organizer_id: 1,
        lottery_id: "",
        ticket_price: 0,
        total_tickets: 0,
        description: "",
        start_date: "",
        end_date: "",
      },
      lotteries: [],
      error: null,
      isLoading: false
    };
  },
  computed: {
    totalRevenue() {
      const total = this.form.ticket_price * this.form.total_tickets;
      return total.toLocaleString('es-CO', {
        style: 'currency',
        currency: 'COP',
        maximumFractionDigits: 0
      });
    },
  },
  async created() {
    await this.fetchLotteries();
  },
  methods: {
    async fetchLotteries() {
      try {
        const response = await axios.get("/api/loterias");
        this.lotteries = response.data;
        this.error = null;
      } catch (error) {
        console.error("Error fetching lotteries:", error);
        this.error = "Error al cargar las loterías. Por favor, intente nuevamente.";
      }
    },
    async submitForm() {
      this.isLoading = true;
      this.error = null;
      
      try {
        const formData = {
          ...this.form,
          ticket_price: parseFloat(this.form.ticket_price),
          total_tickets: parseInt(this.form.total_tickets)
        };

        const response = await axios.post("/api/raffles", formData);
          if (response.data.raffle) {
            // Redirigir o mostrar mensaje de éxito
            this.form = {
            name: "",
            organizer_id: 1, // Puedes ajustar este ID de organizador si es necesario
            lottery_id: "",
            ticket_price: 0,
            total_tickets: 0,
            description: "",
            start_date: "",
            end_date: ""
            };
            alert("Rifa creada exitosamente");
          }
      } catch (error) {
        console.error("Error creating raffle:", error);
        this.error = "Error al crear la rifa. Por favor, verifique los datos e intente nuevamente.";
      } finally {
        this.isLoading = false;
      }
    },
  },
};
</script>