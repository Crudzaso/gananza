<template>
  <!-- Main Container -->
  <div
    :class="['raffle-card shadow-lg rounded-lg p-6 items-center gap-5 mx-auto grid grid-cols-2', theme.cardBackground]"
  >
    <!-- Raffle Image and Countdown -->
    <div>
      <!-- Countdown Timer -->
      <div
        class="countdown p-0.3 x-sm rounded-lg text-center"
        :class="countdownEnded ? 'bg-red-600 text-white' : 'bg-yellow-600 text-white'"
      >
        <p v-if="countdownEnded">¡Ya terminó!</p>
        <p v-else>
          {{ countdown.days }} :
          {{ countdown.hours }} :
          {{ countdown.minutes }} :
          {{ countdown.seconds }}
        </p>
      </div>
      <img
        src="../../../../public/assets/media/auth/Logo-Gananza2.svg"
        alt="Prize"
        class="h-32 w-32 flex items-center justify-center rounded-lg mb-3"
      />
    </div>

    <!-- Raffle Details -->
    <div class="flex flex-col justify-center">
      <h3 :class="['text-lg font-semibold', theme.textPrimary]">{{ raffle.name }}</h3>
      <p :class="theme.textSecondary">Organizador: {{ raffle.organizer.name }}</p>
      <p :class="theme.textSecondary">
        Precio: <span :class="theme.textHighlight">${{ raffle.ticket_price }}</span>
      </p>
      <p :class="theme.textSecondary">Números disponibles: {{ raffle.total_tickets }}</p>
      <p :class="theme.textSecondary">Total vendido: ${{ raffle.total_sales }}</p>
      <p :class="theme.textSecondary">Fecha de juego: <br>{{ raffle.end_date }}</p>

      <!-- Buy Button -->
      <button
        v-if="!countdownEnded"
        @click.prevent="openSelectionModal"
        :class="[theme.buttonPrimary, 'mt-4 py-2 px-4 rounded-lg hover:scale-105 transition']"
      >
        Comprar
      </button>
      <p
        v-else
        class="text-gray-500 mt-4"
      >
        Rifa finalizada
      </p>
    </div>

    <!-- Modal for Selecting Numbers -->
    <TransitionRoot
      appear
      :show="showSelectionModal"
      as="template"
    >
      <Dialog
        as="div"
        @close="closeSelectionModal"
        class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm"
      >
        <TransitionChild
          as="template"
          enter="ease-out duration-300"
          leave="ease-in duration-200"
        >
          <DialogPanel :class="[theme.modalBackground, 'w-full max-w-3xl p-8 rounded-2xl shadow-2xl flex gap-8']">
            <!-- Number Selection -->
            <div class="w-2/3 grid grid-col items-center justify-cente gap-x-6">
              <div class="grid grid-cols-5 gap-4 mb-4">
                <button
                  v-for="number in paginatedNumbers"
                  :key="number"
                  @click="handleNumberClick(number)"
                  :class="['number-button py-2 px-4 rounded-lg transition', selectedNumber.includes(number) ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-blue-600 hover:text-white']"
                >
                  {{ number }}
                </button>
              </div>

              <!-- Buttons: "Limpiar" and "Random" -->
              <div class="flex justify-evenly mt-2 p-6">
                <button
                  @click="clearSelection"
                  :class="[theme.buttonDanger, 'px-4 py-2 rounded-lg']"
                >
                  Limpiar
                </button>
                <button
                  @click="selectRandomNumbers"
                  :class="[theme.buttonPrimary, 'px-4 py-2 rounded-lg']"
                >
                  Random
                </button>
              </div>

              <!-- Pagination for Numbers -->
              <div class="flex justify-center items-center w-full">
                <button
                  @click="goToPreviousPage"
                  :disabled="currentPage === 1"
                  class="px-4 py-2 bg-gray-300 rounded-lg mx-2"
                >
                  &lt;
                </button>
                <button
                  @click="goToNextPage"
                  :disabled="currentPage === totalPages"
                  class="px-4 py-2 bg-gray-300 rounded-lg mx-2"
                >
                  &gt;
                </button>
              </div>
              <div><span>Página {{ currentPage }} de {{ totalPages }}</span></div>
            </div>

            <!-- Invoice Section -->
            <div class="w-1/3 flex flex-col items-center justify-center bg-white p-4 rounded-lg shadow-lg">
              <h3 class="text-lg font-semibold mb-4">Factura</h3>
              <div class="w-full mb-4">
                <label class="text-gray-700">Usuario</label>
                <div class="py-2 px-4 bg-gray-200 rounded-lg text-center">{{ userName || 'None' }}</div>
              </div>
              <div class="w-full mb-4">
                <label class="text-gray-700">Numeros Seleccionados</label>
                <div class="py-2 px-4 bg-gray-200 rounded-lg text-center">
                  {{ selectedNumber.join(', ') || 'Ninguno' }}
                </div>
              </div>
              <button
                @click="proceedToPaymentModal"
                :class="[theme.buttonPrimary, 'px-4 py-2 rounded-lg']"
              >
                Comprar
              </button>
            </div>
          </DialogPanel>
        </TransitionChild>
      </Dialog>
    </TransitionRoot>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useDarkMode } from '@/composables/useDarkMode';
import { TransitionRoot, TransitionChild, Dialog, DialogPanel } from '@headlessui/vue';

/* Props and Reactive Data */
const raffleProps = defineProps({
  raffle: {
    type: Object,
    required: true,
  },
});
const showSelectionModal = ref(false);
const selectedNumber = ref([]);
const countdown = ref({
  days: 0,
  hours: 0,
  minutes: 0,
  seconds: 0,
});
const countdownEnded = ref(false);

const calculateCountdown = () => {
  const now = new Date();
  const endDate = new Date(raffleProps.raffle.end_date);

  const totalMilliseconds = endDate - now;

  if (totalMilliseconds <= 0) {
    countdownEnded.value = true;
    countdown.value = { days: 0, hours: 0, minutes: 0, seconds: 0 };
    return;
  }

  countdownEnded.value = false;

  const totalSeconds = Math.floor(totalMilliseconds / 1000);
  countdown.value = {
    days: Math.floor(totalSeconds / (24 * 60 * 60)),
    hours: Math.floor((totalSeconds % (24 * 60 * 60)) / (60 * 60)),
    minutes: Math.floor((totalSeconds % (60 * 60)) / 60),
    seconds: totalSeconds % 60,
  };
};

let timerInterval;
onMounted(() => {
  calculateCountdown();
  timerInterval = setInterval(calculateCountdown, 1000);
});

onUnmounted(() => {
  clearInterval(timerInterval);
});

const { isDarkMode } = useDarkMode();
const theme = computed(() => ({
  cardBackground: isDarkMode.value ? 'bg-[#1c1c1e]' : 'bg-[#f9f9f9]',
  textPrimary: isDarkMode.value ? 'text-white' : 'text-gray-900',
  textSecondary: isDarkMode.value ? 'text-gray-400' : 'text-gray-600',
  textHighlight: isDarkMode.value ? 'text-yellow-300' : 'text-yellow-600',
  buttonPrimary: 'bg-blue-600 text-white',
}));
</script>

<style scoped>
.raffle-card {
  max-width: 500px;
}

.countdown {
  font-size: 1.2rem;
  font-weight: bold;
}
</style>
