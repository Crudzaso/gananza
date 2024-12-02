<template>
  <!-- Main Container -->
  <div :class="['raffle-card shadow-lg rounded-lg p-4 flex flex-col items-center gap-4 mx-auto', theme.cardBackground]">
    <!-- Raffle Image -->
    <img
      src="../../../../public/assets/media/auth/Letra-Gananza.svg"
      alt="Prize"
      class="h-32 w-32 object-cover rounded-lg mb-3"
    />
    <!-- Raffle Title and Organizer -->
    <h3 :class="['text-lg font-semibold', theme.textPrimary]">{{ raffle.name }}</h3>
    <p :class="theme.textSecondary">Organizador: {{ raffle.organizer.name }}</p>
    <p :class="theme.textSecondary">
      Ticket de precios <span :class="theme.textHighlight">${{ raffle.ticket_price }}</span>
    </p>
    <!-- Buy Button -->
    <button
      @click.prevent="openSelectionModal"
      :class="theme.buttonPrimary"
      class="py-2 px-4 rounded-lg hover:scale-105 transition"
    >
      Comprar
    </button>

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
            <div class="w-2/3 flex flex-col items-center gap-4">
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
              <!-- Pagination for Numbers -->
              <div class="flex justify-center items-center w-full">
                <button
                  @click="goToPreviousPage"
                  :disabled="currentPage === 1"
                  class="px-4 py-2 bg-gray-300 rounded-lg mx-2"
                >
                  Atras
                </button>
                <span :class="[theme.textPrimary]">Página {{ currentPage }} de {{ totalPages }}</span>
                <button
                  @click="goToNextPage"
                  :disabled="currentPage === totalPages"
                  class="px-4 py-2 bg-gray-300 rounded-lg mx-2"
                >
                  Siguiente
                </button>
              </div>
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
                <div class="py-2 px-4 bg-gray-200 rounded-lg text-center">{{ selectedNumber.join(', ') || 'Ninguno' }}
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

    <!-- Modal for Invoice -->
    <TransitionRoot
      appear
      :show="showModal"
      as="template"
    >
      <Dialog
        as="div"
        @close="closeModal"
        class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm"
      >
        <TransitionChild
          as="template"
          enter="ease-out duration-300"
          leave="ease-in duration-200"
        >
          <DialogPanel :class="[theme.modalBackground, 'w-full max-w-lg p-8 rounded-2xl shadow-2xl']">
            <div>
              <!-- Invoice Table -->
              <table
                cellspacing="0"
                cellpadding="10"
                class="w-full text-left border-collapse"
              >
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
                      ${{ selectedNumber.length > 0 ? (raffle.ticket_price * selectedNumber.length).toFixed(2) : '0.00'
                      }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- Payment and Close Buttons -->
            <button
              @click="openVerificationModal"
              :class="[theme.buttonPrimary, 'px-4 py-2 rounded-lg mr-2']"
            >
              Ir a pagar
            </button>
            <button
              @click="closeModal"
              :class="[theme.buttonDanger, 'px-4 py-2 rounded-lg']"
            >
              Cerrar
            </button>
          </DialogPanel>
        </TransitionChild>
      </Dialog>
    </TransitionRoot>

    <!-- Payment Verification Modal -->
    <TransitionRoot
      appear
      :show="showVerificationModal"
      as="template"
    >
      <Dialog
        as="div"
        @close="closeVerificationModal"
        class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm"
      >
        <TransitionChild
          as="template"
          enter="ease-out duration-300"
          leave="ease-in duration-200"
        >
          <DialogPanel :class="[theme.modalBackground, 'w-full max-w-lg p-8 rounded-2xl shadow-2xl']">
            <h2>Aquí va la pasarela de pagos</h2>
            <!-- Receipt Validation Form -->
            <button
              @click="closeVerificationModal"
              :class="[theme.buttonDanger, 'px-4 py-2 rounded-lg mt-4']"
            >
              Cerrar
            </button>
          </DialogPanel>
        </TransitionChild>
      </Dialog>
    </TransitionRoot>
  </div>
</template>

<script setup>
/* Imports and Setup */
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useDarkMode } from '@/composables/useDarkMode';
import { TransitionRoot, TransitionChild, Dialog, DialogPanel } from '@headlessui/vue';

/* Props and Reactive Data */
const raffleProps = defineProps({ raffle: Object });
const showSelectionModal = ref(false);
const showModal = ref(false);
const showVerificationModal = ref(false);
const totalTickets = ref(raffleProps.raffle.total_tickets || 0);
const referenceNumber = ref('');
const numbers = ref([]);
const selectedNumber = ref([]);

/* Pagination Variables */
const currentPage = ref(1);
const itemsPerPage = 15;
const totalPages = computed(() => Math.ceil(totalTickets.value / itemsPerPage));

/* User and Theme Settings */
const user = usePage().props.auth?.user || null;
const userName = ref(user ? user.name : 'Unauthenticated User');
const { isDarkMode } = useDarkMode();
const theme = computed(() => ({
  textPrimary: isDarkMode.value ? 'text-white' : 'text-black',
  cardBackground: isDarkMode.value ? 'bg-[#1c1c1e]' : 'bg-[#f9f9f9]',
  modalBackground: isDarkMode.value ? 'bg-[#2c2c2e]' : 'bg-white',
  buttonPrimary: 'bg-blue-600 text-white',
  buttonDanger: 'bg-red-500 text-white',
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

/* Modal Logic */
const openSelectionModal = () => {
  initializeNumbers();
  showSelectionModal.value = true;
};

const closeSelectionModal = () => {
  showSelectionModal.value = false;
};

const proceedToPaymentModal = () => {
  if (selectedNumber.value.length === 0) {
    alert('Please select at least one number.');
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

const openVerificationModal = () => {
  closeModal();
  showVerificationModal.value = true;
};

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
