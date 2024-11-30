<template>
  <div :class="['raffle-card shadow-lg rounded-lg p-4 flex flex-col items-center gap-4 mx-auto', theme.cardBackground]">
    <img
      src="../../../../public/assets/media/auth/Letra-Gananza.svg"
      alt="Premio"
      class="h-32 w-32 object-cover rounded-lg mb-3"
    />
    <h3 :class="['text-lg font-semibold', theme.textPrimary]">{{ raffle.name }}</h3>
    <p :class="theme.textSecondary">Organizador: {{ raffle.organizer.name }}</p>
    <p :class="theme.textSecondary">Precio/Ticket: <span :class="theme.textHighlight">${{ raffle.ticket_price }}</span>
    </p>
    <button
      @click.prevent="openSelectionModal"
      :class="theme.buttonPrimary"
      class="py-2 px-4 rounded-lg hover:scale-105 transition"
    >
      Comprar
    </button>

    <!-- Nuevo Modal: Selección de Número con Factura -->
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
            <!-- Sección izquierda: Números y Paginación -->
            <div class="w-2/3 flex flex-col items-center gap-4">
              <!-- Números -->
              <div class="grid grid-cols-5 gap-4 mb-4">
                <button
                  v-for="number in paginatedNumbers"
                  :key="number"
                  @click="handleNumberClick(number)"
                  :class="['number-button py-2 px-4 rounded-lg transition', selectedNumber === number ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-blue-600 hover:text-white']"
                >
                  {{ number }}
                </button>
              </div>

              <!-- Paginación centrada debajo -->
              <div class="flex justify-center items-center w-full">
                <button
                  @click="goToPreviousPage"
                  :disabled="currentPage === 1"
                  class="px-4 py-2 bg-gray-300 rounded-lg mx-2"
                >
                  Anterior
                </button>
                <span>Página {{ currentPage }} de {{ totalPages }}</span>
                <button
                  @click="goToNextPage"
                  :disabled="currentPage === totalPages"
                  class="px-4 py-2 bg-gray-300 rounded-lg mx-2"
                >
                  Siguiente
                </button>
              </div>
            </div>

            <!-- Sección derecha: Factura -->
            <div class="w-1/3 flex flex-col items-center justify-center bg-white p-4 rounded-lg shadow-lg">
              <h3 class="text-lg font-semibold mb-4">Factura</h3>
              <div class="w-full mb-4">
                <label class="text-gray-700">Usuario</label>
                <div class="py-2 px-4 bg-gray-200 rounded-lg text-center">{{ userName || 'Ninguno' }}</div>
              </div>
              <div class="w-full mb-4">
                <label class="text-gray-700">Número</label>
                <div class="py-2 px-4 bg-gray-200 rounded-lg text-center">{{ selectedNumber || 'Ninguno' }}</div>
              </div>
              <button
                @click="proceedToPaymentModal"
                :class="[theme.buttonPrimary, 'px-4 py-2 rounded-lg']"
              >Comprar</button>
            </div>
          </DialogPanel>
        </TransitionChild>
      </Dialog>
    </TransitionRoot>

    <!-- Primer Modal: QR Code -->
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
            <h2 :class="['text-xl font-semibold text-center mb-4', theme.textPrimary]">Pagar con Nequi</h2>
            <div class="flex justify-center mb-4">
              <img
                src="/assets/media/gananza/qr-gananza.png"
                alt="QR de Nequi"
                class="w-48 h-48 qr"
              >
            </div>
            <button
              @click="openVerificationModal"
              :class="[theme.buttonPrimary, 'px-4 py-2 rounded-lg mr-2']"
            >Siguiente</button>
            <button
              @click="closeModal"
              :class="[theme.buttonDanger, 'px-4 py-2 rounded-lg']"
            >Cerrar</button>
          </DialogPanel>
        </TransitionChild>
      </Dialog>
    </TransitionRoot>

    <!-- Segundo Modal: Ingreso del Comprobante -->
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
            <h2 :class="['text-xl font-semibold text-center mb-4', theme.textPrimary]">Validar Comprobante</h2>
            <form @submit.prevent="validatePayment">
              <div class="mb-4">
                <label class="text-gray-700">Número de Comprobante</label>
                <input
                  v-model="referenceNumber"
                  type="text"
                  class="w-full p-2 border rounded-lg"
                  placeholder="Ingresa el número de comprobante"
                  required
                />
              </div>
              <button
                type="submit"
                :class="[theme.buttonPrimary, 'px-4 py-2 rounded-lg']"
              >Enviar</button>
            </form>
            <button
              @click="closeVerificationModal"
              :class="[theme.buttonDanger, 'px-4 py-2 rounded-lg mt-4']"
            >Cerrar</button>
          </DialogPanel>
        </TransitionChild>
      </Dialog>
    </TransitionRoot>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useDarkMode } from '@/composables/useDarkMode';
import { TransitionRoot, TransitionChild, Dialog, DialogPanel } from '@headlessui/vue';

const raffleProps = defineProps({ raffle: Object });
const showSelectionModal = ref(false);
const showModal = ref(false);
const showVerificationModal = ref(false);
const totalTickets = ref(raffleProps.raffle.total_tickets || 0);
const referenceNumber = ref('');
const numbers = ref([]);
const selectedNumber = ref(null);
const currentPage = ref(1);
const itemsPerPage = 15;
const totalPages = computed(() => Math.ceil(totalTickets.value / itemsPerPage));


const user = usePage().props.auth?.user || null;
const userName = ref(user ? user.name : 'Usuario no autenticado');


// Tema
const { isDarkMode } = useDarkMode();
const theme = computed(() => ({
  cardBackground: isDarkMode.value ? 'bg-[#1c1c1e]' : 'bg-[#f9f9f9]',
  modalBackground: isDarkMode.value ? 'bg-[#2c2c2e]' : 'bg-white',
  buttonPrimary: 'bg-blue-600 text-white',
  buttonDanger: 'bg-red-500 text-white',
}));

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


const openSelectionModal = () => {
  initializeNumbers();
  console.log(raffleProps);
  showSelectionModal.value = true;
};

const closeSelectionModal = () => {
  showSelectionModal.value = false;
};

const handleNumberClick = (number) => {
  if (selectedNumber.value === null || selectedNumber.value === undefined) {
    selectedNumber.value = '';
  }
  const selectedNumbersArray = selectedNumber.value.trim().split(' ').filter(Boolean);
  const numberIndex = selectedNumbersArray.indexOf(number.toString());

  if (numberIndex === -1) {

    selectedNumbersArray.push(number);
  } else {

    selectedNumbersArray.splice(numberIndex, 1);
  }

  selectedNumber.value = selectedNumbersArray.join(' ');

  console.log(`Números seleccionados: ${selectedNumber.value.trim()}`);
};

const proceedToPaymentModal = () => {
  if (!selectedNumber.value) {
    alert('Por favor selecciona un número antes de continuar.');
    return;
  }
  closeSelectionModal();
  showModal.value = true;
};

// Función para abrir el modal QR
const openModal = () => {
  showModal.value = true;
};

// Función para cerrar el modal QR
const closeModal = () => {
  showModal.value = false;
};

// Función para abrir el modal de verificación después de hacer clic en "Siguiente"
const openVerificationModal = () => {
  closeModal(); // Cerrar el modal actual
  showVerificationModal.value = true; // Abrir el modal de verificación
};

// Función para cerrar el modal de verificación
const closeVerificationModal = () => {
  showVerificationModal.value = false;
};

const createPayment = async () => {
  try {
    const userId = user?.id;
    const raffleId = raffleProps.raffle.id;
    const amount = raffleProps.raffle.ticket_price;
    const paymentMethod = "NEQUI";
    const paymentDate = new Date().toISOString();

    const response = await axios.post('/payment/createPayment', {
      user_id: userId,
      raffle_id: raffleId,
      amount: amount,
      payment_method: paymentMethod,
      payment_date: paymentDate,
    });

    console.log("Respuesta de creación de Payment:", response.data);
  } catch (error) {
    console.error("Error al crear el Payment:", error.response?.data || error.message);
    alert('Error al crear el Payment.');
  }
};

const createTicket = async () => {
  try {
    const userId = user?.id;
    const raffleId = raffleProps.raffle.id;
    const ticketNumber = selectedNumber.value;
    const purchaseDate = new Date().toISOString();
    const endDate = raffleProps.raffle.end_date;
    const verificationCode = referenceNumber.value;

    const response = await axios.post('/ticket/create', {
      raffle_id: raffleId,
      user_id: userId,
      ticket_number: ticketNumber,
      purchase_date: purchaseDate,
      end_date: endDate,
      verification_code: verificationCode,
    });

    console.log("Respuesta de creación de Ticket:", response.data);
  } catch (error) {
    console.error("Error al crear el Ticket:", error.response?.data || error.message);
    alert('Error al crear el Ticket.');
  }
};



const validatePayment = async () => {
  try {
    alert("Validando el pago, por favor espera...");
    console.log("Número de comprobante ingresado:", referenceNumber.value);
    console.log("Monto ingresado:", raffleProps.raffle.ticket_price);

    // Validar el pago con la API
    const response = await axios.post('/verify-payment', {
      referenceNumber: referenceNumber.value,
      monto: raffleProps.raffle.ticket_price,
    });

    console.log("Respuesta del servidor:", response.data);
    alert(response.data.message);

    if (response.data.status === 'success') {
      // Crear el registro de Payment
      await createPayment();

      // Crear el registro de Ticket
      await createTicket();

      // Cerrar el modal de verificación si todo es exitoso
      closeVerificationModal();
      alert('Pago y Ticket creados exitosamente.');
    }
  } catch (error) {
    console.error("Error al validar el pago:", error.response?.data || error.message);
    alert(error.response?.data?.message || 'Error al validar el pago.');
  }
};

</script>

<style scoped>
.modal {
  z-index: 9999;
}

.qr {
  width: 300px;
  height: 300px;
}

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
</style>
