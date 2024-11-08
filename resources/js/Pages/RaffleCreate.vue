<template>
  <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Crear nueva rifa</h2>
    <form @submit.prevent="submitForm">
      <!-- Nombre de la rifa -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700" for="name_raffle">Nombre de la rifa</label>
        <input
          type="text"
          v-model="form.name_raffle"
          id="name_raffle"
          class="w-full mt-1 p-2 border border-gray-300 rounded"
          required
        />
      </div>

      <!-- Lotería -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700" for="lottery_id">Lotería</label>
        <select v-model="form.lottery_id" id="lottery_id" class="w-full mt-1 p-2 border border-gray-300 rounded">
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
          v-model="form.ticket_price"
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
          v-model="form.total_tickets"
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
      >
        Crear rifa
      </button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        name_raffle: "",
        lottery_id: "",
        ticket_price: 0,
        total_tickets: 0,
        description: "",
        start_date: "",
        end_date: "",
      },
      lotteries: [],
    };
  },
  computed: {
    totalRevenue() {
      return (this.form.ticket_price * this.form.total_tickets).toFixed(2);
    },
  },
  mounted() {
    this.fetchLotteries();
  },
  methods: {
    async fetchLotteries() {
      try {
        const response = await axios.get("/api/lotteries");
        this.lotteries = response.data;
      } catch (error) {
        console.error("Error fetching lotteries:", error);
      }
    },
    async submitForm() {
      try {
        const response = await axios.post("/api/raffles", this.form);
        alert("Rifa creada exitosamente!");
        this.$router.push("/raffles");
      } catch (error) {
        console.error("Error creating raffle:", error);
        alert("Hubo un error al crear la rifa.");
      }
    },
  },
};
</script>

<style scoped>
/* Estilos adicionales opcionales */
</style>
