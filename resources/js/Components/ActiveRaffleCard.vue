<!-- RaffleCard.vue -->
<template>
    <div class="raffle-card bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
      <!-- Imagen de la rifa -->
      <div class="relative h-48 overflow-hidden">
        <img 
          :src="raffle.multimedia?.[0]?.url || '/default-raffle.jpg'" 
          class="w-full h-full object-cover"
          alt="Raffle Image"
        />
        <div class="absolute top-0 right-0 bg-primary-600 text-white px-3 py-1 rounded-bl-lg">
          {{ formatPrice(raffle.ticket_price) }}
        </div>
      </div>
      
      <!-- Contenido de la tarjeta -->
      <div class="p-4">
        <h3 class="text-xl font-bold text-gray-800 mb-2 truncate">{{ raffle.name }}</h3>
        
        <!-- Barra de progreso -->
        <div class="mb-4">
          <div class="flex justify-between text-sm mb-1">
            <span>{{ raffle.tickets_sold }} vendidos</span>
            <span>{{ raffle.total_tickets }} total</span>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-2">
            <div 
              class="bg-primary-600 rounded-full h-2 transition-all duration-300"
              :style="{ width: `${(raffle.tickets_sold / raffle.total_tickets) * 100}%` }"
            ></div>
          </div>
        </div>
        
        <!-- Detalles adicionales -->
        <div class="flex justify-between items-center text-sm text-gray-600 mb-4">
          <div class="flex items-center">
            <i class="fas fa-user mr-1"></i>
            <span>{{ raffle.organizer.name }}</span>
          </div>
          <div class="flex items-center">
            <i class="fas fa-clock mr-1"></i>
            <span>{{ formatTimeRemaining(raffle.end_date) }}</span>
          </div>
        </div>
        
        <!-- Botón de acción -->
        <button 
          class="w-full bg-primary-600 text-white py-2 rounded-lg hover:bg-primary-700 transition-colors duration-300"
          @click="$emit('participate', raffle.id)"
        >
          Participar
        </button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'RaffleCard',
    props: {
      raffle: {
        type: Object,
        required: true
      }
    },
    methods: {
      formatPrice(price) {
        return new Intl.NumberFormat('es-MX', {
          style: 'currency',
          currency: 'MXN'
        }).format(price)
      },
      formatTimeRemaining(endDate) {
        const end = new Date(endDate)
        const now = new Date()
        const diff = end - now
  
        const days = Math.floor(diff / (1000 * 60 * 60 * 24))
        
        if (days > 0) {
          return `${days} días restantes`
        }
        
        const hours = Math.floor(diff / (1000 * 60 * 60))
        return `${hours} horas restantes`
      }
    }
  }
  </script>