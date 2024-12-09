<template>
  <!-- Main Container -->
  <div
    :class="['raffle-card shadow-lg rounded-xl p-8 items-center gap-8 mx-auto flex flex-col md:flex-row w-full md:w-3/10', theme.cardBackground]">
    <!-- Image and Countdown -->
    <div class="flex flex-col items-center justify-center gap-6 w-full md:w-1/3">
      <!-- Countdown Timer -->
      <div class="countdown py-2 px-4 rounded-full text-center text-sm font-semibold shadow-md"
        :class="countdownEnded ? 'bg-red-500 text-white' : 'bg-yellow-500 text-white'">
        <p v-if="countdownEnded">¡Ya terminó!</p>
        <p v-else>
          {{ countdown.days }} días, {{ countdown.hours }}:{{ countdown.minutes }}:{{ countdown.seconds }}
        </p>
      </div>

      <!-- Raffle Image -->
      <img :src="raffle.image ? `/storage/${raffle.image}` : '/assets/media/auth/Login-image.svg'" alt="Prize"
        class="h-48 w-48 object-cover rounded-lg shadow-md" @error="handleImageError" />
    </div>

    <!-- Raffle Details -->
    <div class="flex flex-col justify-between w-full md:w-2/3">
      <!-- Title -->
      <div>
        <h3 class="text-2xl font-bold mb-4 text-center md:text-left" :class="[theme.textPrimary, 'text-shadow-md']">
          {{ raffle.name }}
        </h3>
      </div>

      <!-- Organizer and Details -->
      <div class="text-base mb-6 space-y-2">
        <p :class="theme.textSecondary">
          Organizador: <span class="font-medium">{{ raffle.organizer.name }}</span>
        </p>
        <p :class="theme.textSecondary">
          Precio: <span class="font-semibold">${{ raffle.ticket_price }}</span>
        </p>
        <p :class="theme.textSecondary">
          Números disponibles: <span class="font-medium">{{ raffle.total_tickets }}</span>
        </p>
        <p :class="theme.textSecondary">
          Loteria: <span class="font-medium">{{ raffle.lottery ? raffle.lottery.name : 'No especificada' }}</span>
        </p>
      </div>

      <!-- Buy Button -->
      <div class="text-center">
        <button v-if="!countdownEnded" @click.prevent="openSelectionModal"
          :class="[theme.buttonPrimary, 'py-3 px-8 rounded-lg text-base font-semibold hover:scale-105 transition']">
          Comprar
        </button>

        <p v-else class="text-gray-500 text-center">
          Rifa finalizada
        </p>
        <!-- Modal for Selecting Numbers -->
        <TransitionRoot appear :show="showSelectionModal" as="template">
          <Dialog as="div" @close="closeSelectionModal"
            class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm">
            <TransitionChild as="template" enter="ease-out duration-300" leave="ease-in duration-200">
              <DialogPanel
                :class="['w-full max-w-3xl p-8 rounded-2xl shadow-2xl flex gap-8', theme.modalBackground, 'border border-gray-600']">
                <!-- Number Selection -->
                <div class="w-2/3 grid items-center gap-x-6">
                  <div class="grid grid-cols-5 gap-4 mb-4">
                    <button v-for="number in paginatedNumbers" :key="number" @click="handleNumberClick(number)" :class="[
                      'number-button py-2 px-4 rounded-lg transition',
                      selectedNumber.includes(number)
                        ? 'bg-blue-500 text-white'
                        : theme.buttonNeutral,
                    ]">
                      {{ number }}
                    </button>

                  </div>

                  <!-- Buttons: "Limpiar" and "Random" -->
                  <div class="flex justify-evenly mt-2 p-6">
                    <button @click="clearSelection"
                      :class="[theme.buttonDanger, 'px-4 py-2 rounded-lg text-base font-semibold']">
                      Limpiar
                    </button>
                    <button @click="selectRandomNumbers"
                      :class="[theme.buttonPrimary, 'px-4 py-2 rounded-lg text-base font-semibold']">
                      Random
                    </button>
                  </div>


                  <!-- Pagination for Numbers -->
                  <div class="flex justify-center items-center w-full">
                    <button @click="goToPreviousPage" :disabled="currentPage === 1"
                      :class="[theme.buttonNeutral, 'px-4 py-2 rounded-lg mx-2']">
                      &lt;
                    </button>
                    <button @click="goToNextPage" :disabled="currentPage === totalPages"
                      :class="[theme.buttonNeutral, 'px-4 py-2 rounded-lg mx-2']">
                      &gt;
                    </button>
                  </div>

                  <div class="text-center text-gray-300 mt-4" :class="theme.textPrimary">
                    Página {{ currentPage }} de {{ totalPages }}
                  </div>
                </div>

                <!-- Invoice Section -->
                <div class="w-1/3 flex flex-col items-center justify-center p-4 rounded-lg shadow-lg"
                  :class="theme.invoiceBackground">
                  <h3 class="text-lg font-semibold mb-4" :class="theme.textPrimary">
                    Factura
                  </h3>
                  <div class="w-full mb-4">
                    <label :class="theme.textSecondary">Usuario</label>
                    <div class="py-2 px-4 rounded-lg text-center" :class="theme.buttonNeutral, theme.textPrimary">
                      {{ userName || 'None' }}
                    </div>
                  </div>
                  <div class="w-full mb-4">
                    <label :class="theme.textSecondary">Números Seleccionados</label>
                    <div class="py-2 px-4 rounded-lg text-center" :class="theme.buttonNeutral, theme.textPrimary">
                      {{ selectedNumber.join(', ') || 'Ninguno' }}
                    </div>
                  </div>
                  <button @click="proceedToPaymentModal"
                    :class="[theme.buttonPrimary, 'px-4 py-2 rounded-lg text-base font-semibold']">
                    Comprar
                  </button>
                </div>
              </DialogPanel>
            </TransitionChild>
          </Dialog>
        </TransitionRoot>

        <TransitionRoot appear :show="showWarningModal" as="template">
          <Dialog as="div" @close="closeWarningModal"
            class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm">
            <TransitionChild as="template" enter="ease-out duration-300" leave="ease-in duration-200">
              <DialogPanel :class="[theme.modalBackground, 'w-full max-w-md p-8 rounded-2xl shadow-2xl']">
                <h2 class="text-lg font-semibold mb-4 ">Ops</h2>
                <p class="mb-4 p-14 text-xl text-center">¡Por favor, selecciona al menos un número antes de continuar
                  con
                  la compra!
                </p>
                <button @click="closeWarningModal" :class="[theme.buttonDanger, 'px-4 py-2 rounded-lg']">
                  Cerrar
                </button>
              </DialogPanel>
            </TransitionChild>
          </Dialog>
        </TransitionRoot>

        <TransitionRoot appear :show="showModal" as="template">
          <Dialog as="div" @close="closeModal"
            class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm">
            <TransitionChild as="template" enter="ease-out duration-300" leave="ease-in duration-200">
              <DialogPanel :class="[theme.modalBackground, 'w-full max-w-lg p-14 rounded-2xl shadow-2xl ']">
                <div class="py-10">
                  <!-- Invoice Table -->
                  <table cellspacing="10" cellpadding="10" class="w-full text-left border-collapse ">
                    <thead>
                      <tr>
                        <th class="border-b-2 py-2">Nombre</th>
                        <th class="border-b-2 py-2">Tus Numeros</th>
                        <th class="border-b-2 py-2">Total a pagar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="border-t py-2">{{ userName }}</td>
                        <td class="border-t py-2">{{ selectedNumber.join(', ') || 'None' }}</td>
                        <td class="border-t py-2">
                          ${{ selectedNumber.length > 0 ? (raffle.ticket_price * selectedNumber.length).toFixed(2) :
                            '0.00'
                          }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- Payment and Close Buttons -->
                <button @click="openVerificationModal" :class="[theme.buttonPrimary, 'px-4 py-2 rounded-lg mr-2']">
                  Ir a pagar
                </button>
                <button @click="closeModal" :class="[theme.buttonDanger, 'px-4 py-2 rounded-lg']">
                  Cerrar
                </button>
              </DialogPanel>
            </TransitionChild>
          </Dialog>
        </TransitionRoot>

        <!-- Payment Verification Modal -->
        <TransitionRoot appear :show="showVerificationModal" as="template">
          <Dialog as="div" @close="closeVerificationModal"
            class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm">
            <TransitionChild as="template" enter="ease-out duration-300" leave="ease-in duration-200">
              <DialogPanel :class="[theme.modalBackground, 'w-full max-w-lg p-8 rounded-2xl shadow-2xl']">
                <h2>MercadoPago</h2>
                <div id="wallet_container" class="my-4"></div>
                <button @click="closeVerificationModal" :class="[theme.buttonDanger, 'px-4 py-2 rounded-lg mt-4']">
                  Cerrar
                </button>
              </DialogPanel>
            </TransitionChild>
          </Dialog>
        </TransitionRoot>

      </div>
    </div>
  </div>
</template>

<script setup>
/* Imports and Setup */
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useDarkMode } from '@/composables/useDarkMode';
import { TransitionRoot, TransitionChild, Dialog, DialogPanel } from '@headlessui/vue';
import axios from "axios";


const raffleProps = defineProps({ raffle: Object });
const showSelectionModal = ref(false);
const showModal = ref(false);
const showVerificationModal = ref(false);
const totalTickets = ref(raffleProps.raffle.total_tickets || 0);
const referenceNumber = ref('');
const numbers = ref([]);
const selectedNumber = ref([]);
const showWarningModal = ref(false);
const defaultImage = '/assets/media/auth/Login-image.svg';
const countdown = ref({
  days: 0,
  hours: 0,
  minutes: 0,
  seconds: 0,
});
const countdownEnded = ref(false);

const handleImageError = (event) => {
  event.target.src = defaultImage;
};

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



/* Pagination Variables */
const currentPage = ref(1);
const itemsPerPage = 15;
const totalPages = computed(() => Math.ceil(totalTickets.value / itemsPerPage));

/* User and Theme Settings */
const user = usePage().props.auth?.user || null;
const userName = ref(user ? user.name : 'Unauthenticated User');
const { isDarkMode } = useDarkMode();
const theme = computed(() => ({
  cardBackground: isDarkMode.value ? 'bg-[#1c1c1e]' : 'bg-[#ffffff]', // Blanco puro para Light Mode
  modalBackground: isDarkMode.value ? 'bg-[#2E2E38]' : 'bg-[#f9f9f9]', // Fondo claro para modales en Light Mode
  invoiceBackground: isDarkMode.value ? 'bg-[#3E3E4A]' : 'bg-[#ffffff]', // Fondo limpio para Light Mode
  buttonPrimary: isDarkMode.value
    ? 'bg-blue-500 text-white hover:bg-blue-400'
    : 'bg-blue-600 text-white hover:bg-blue-500', // Azul vibrante para ambos modos
  buttonDanger: isDarkMode.value
    ? 'bg-red-500 text-white hover:bg-red-400'
    : 'bg-red-600 text-white hover:bg-red-500', // Rojo más claro en Light Mode
  textPrimary: isDarkMode.value ? 'text-white' : 'text-gray-900', // Texto principal
  textSecondary: isDarkMode.value ? 'text-gray-400' : 'text-gray-700', // Texto secundario
  buttonNeutral: isDarkMode.value
    ? 'bg-gray-700 text-gray-300 hover:bg-gray-600'
    : 'bg-gray-200 text-gray-600 hover:bg-gray-300', // Botones neutrales claros en Light Mode
}));

/* Number Selection Logic */
const initializeNumbers = () => {
  numbers.value = Array.from({ length: totalTickets.value }, (_, i) => i + 1);
};

const paginatedNumbers = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return numbers.value.slice(start, end);
});

const goToNextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value += 1;
  }
};

const goToPreviousPage = () => {
  if (currentPage.value > 1) {
    currentPage.value -= 1;
  }
};

const handleNumberClick = (number) => {
  const index = selectedNumber.value.indexOf(number);
  if (index === -1) {
    selectedNumber.value.push(number);
  } else {
    selectedNumber.value.splice(index, 1);
  }
};

/* New Functions for Buttons */
const clearSelection = () => {
  selectedNumber.value = [];
};

const selectRandomNumbers = () => {
  const availableNumbers = paginatedNumbers.value;
  const randomNumbers = [];
  while (randomNumbers.length < 2 && availableNumbers.length > 0) {
    const randomIndex = Math.floor(Math.random() * availableNumbers.length);
    const number = availableNumbers[randomIndex];
    if (!randomNumbers.includes(number)) {
      randomNumbers.push(number);
    }
  }
  selectedNumber.value = randomNumbers;
};

/* Modal Logic */
const openSelectionModal = () => {
  initializeNumbers();
  showSelectionModal.value = true;
};

const closeSelectionModal = () => {
  showSelectionModal.value = false;
};
const openWarningModal = () => {
  showWarningModal.value = true;
};

const closeWarningModal = () => {
  showWarningModal.value = false;
};


const proceedToPaymentModal = () => {
  if (selectedNumber.value.length === 0) {
    openWarningModal();
    return;
  }
  closeSelectionModal();
  showModal.value = true;
};

const openModal = () => {
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
};

let timerInterval;
onMounted(() => {
  calculateCountdown();
  timerInterval = setInterval(calculateCountdown, 1000);
});

onUnmounted(() => {
  clearInterval(timerInterval);
});

const preferenceId = ref(null); // ID de la preferencia

// Función para obtener el preferenceId desde el backend
const fetchPreferenceId = async () => {
  try {
    const payload = {
      amount: 1000, // Ajusta el monto dinámicamente
      numbers: [1, 2, 3], // Números seleccionados
    };
    const response = await axios.post('/api/mercadopago/create-payment', payload);
    if (response.data.id) {
      preferenceId.value = response.data.id;
      initializeMercadoPago(response.data.id); // Inicializa MercadoPago
    } else {
      throw new Error('No se recibió un ID de preferencia válido.');
    }
  } catch (error) {
    console.error('Error obteniendo el preferenceId:', error);
    alert('Ocurrió un error al obtener la preferencia de pago.');
  }
};

// Función para inicializar MercadoPago
const initializeMercadoPago = (preferenceId) => {
  if (!window.MercadoPago) {
    console.error('SDK de MercadoPago no cargado.');
    return;
  }
  // Limpiar el contenedor antes de inicializar
  const walletContainer = document.getElementById('wallet_container');
  if (walletContainer) walletContainer.innerHTML = '';

  // Inicializar MercadoPago
  const mp = new window.MercadoPago('APP_USR-3f0baf72-345b-40ac-ba99-745f71d22b81', {
    locale: 'es-MX', // Idioma
  });

  // Renderizar el botón de pago
  mp.bricks().create('wallet', 'wallet_container', {
    initialization: {
      preferenceId: preferenceId,
      redirectMode: 'modal', // Cambia a 'redirect' si prefieres redirección
    },
  });
};

// Abrir el modal y cargar el SDK si no está cargado
const openVerificationModal = () => {
  showVerificationModal.value = true;

  if (!window.MercadoPago) {
    // Cargar el script de MercadoPago
    const script = document.createElement('script');
    script.src = 'https://sdk.mercadopago.com/js/v2';
    script.onload = fetchPreferenceId; // Cargar preferencia después de cargar el SDK
    document.body.appendChild(script);
  } else {
    fetchPreferenceId(); // Si ya está cargado, solo obtener preferencia
  }
};

// Cerrar el modal
const closeVerificationModal = () => {
  showVerificationModal.value = false;
};

</script>


<style scoped>
/* Button Styles */
.number-button {
  transition: transform 0.2s, box-shadow 0.2s;
}

.number-button:hover {
  cursor: pointer;
  transform: scale(1.05);
}

.number-button:active,
.number-button.bg-blue-600 {
  transform: scale(0.95);
  box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.2);
}

.number-button.bg-blue-600 {
  background-color: #2563eb;
  color: #fff;
}

.number-button.bg-gray-200 {
  background-color: #f9f9f9;
}

.number-button.selected {
  background-color: #2563eb;
}
</style>
