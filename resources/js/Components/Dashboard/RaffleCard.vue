<template>
  <div :class="['raffle-card shadow-lg rounded-lg p-4 flex flex-col items-center gap-4 mx-auto', theme.cardBackground]">
    <!-- Mostrar la imagen de la rifa -->
    <img :src="raffleImage" alt="Imagen de la Rifa" class="h-32 w-32 object-cover rounded-lg mb-3" />
    <h3 :class="['text-lg font-semibold', theme.textPrimary]">{{ raffle.name }}</h3>
    <p :class="theme.textSecondary">Organizador: {{ raffle.organizer.name }}</p>
    <p :class="theme.textSecondary">Precio/Ticket: <span :class="theme.textHighlight">${{ raffle.ticket_price }}</span></p>
    <button @click.prevent="openPaymentModal" :class="theme.buttonPrimary" class="py-2 px-4 rounded-lg hover:scale-105 transition">
      Comprar
    </button>

    <!-- Primer Modal: QR Code -->
    <TransitionRoot appear :show="showModal" as="template">
      <Dialog as="div" @close="closeModal" class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm">
        <TransitionChild as="template" enter="ease-out duration-300" leave="ease-in duration-200">
          <DialogPanel :class="[theme.modalBackground, 'w-full max-w-lg p-8 rounded-2xl shadow-2xl']">
            <h2 :class="['text-xl font-semibold text-center mb-4', theme.textPrimary]">Pagar con Nequi</h2>
            <div class="flex justify-center mb-4">
              <img src="/assets/media/gananza/qr-gananza.png" alt="QR de Nequi" class="w-48 h-48 qr">
            </div>
            <div class="flex justify-center mb-4">
              <button @click="openVerificationModal" :class="[theme.buttonPrimary, 'btn-nequi']">Siguiente</button>
            </div>
            <button @click="closeModal" :class="[theme.buttonDanger, 'px-4 py-2 rounded-lg']">Cerrar</button>
          </DialogPanel>
        </TransitionChild>
      </Dialog>
    </TransitionRoot>

    <!-- Segundo Modal: Ingreso del Comprobante -->
    <TransitionRoot appear :show="showVerificationModal" as="template">
      <Dialog as="div" @close="closeVerificationModal" class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm">
        <TransitionChild as="template" enter="ease-out duration-300" leave="ease-in duration-200">
          <DialogPanel :class="[theme.modalBackground, 'w-full max-w-lg p-8 rounded-2xl shadow-2xl']">
            <h2 :class="['text-xl font-semibold text-center mb-4', theme.textPrimary]">Validar Comprobante</h2>
            <form @submit.prevent="validatePayment">
              <div class="mb-4">
                <label :class="theme.textSecondary">Número de Comprobante</label>
                <input v-model="referenceNumber" type="text" class="w-full p-2 border rounded-lg" placeholder="Ingresa el número de comprobante" required />
              </div>
              <button type="submit" :class="[theme.buttonPrimary, 'px-4 py-2 rounded-lg']">Enviar</button>
            </form>
            <button @click="closeVerificationModal" :class="[theme.buttonDanger, 'px-4 py-2 rounded-lg mt-4']">Cerrar</button>
          </DialogPanel>
        </TransitionChild>
      </Dialog>
    </TransitionRoot>
  </div>
</template>

<script setup>
import { computed, ref, toRefs } from 'vue';
import axios from 'axios';
import { useDarkMode } from '@/composables/useDarkMode';
import { TransitionRoot, TransitionChild, Dialog, DialogPanel } from '@headlessui/vue';

const props = defineProps({ raffle: Object });
const { raffle } = toRefs(props);
const { isDarkMode } = useDarkMode();
const showModal = ref(false);
const showVerificationModal = ref(false);
const referenceNumber = ref('');

/** Computed property para obtener la URL de la imagen de la rifa */
const raffleImage = computed(() => {
  // Verificar si hay una imagen guardada; si no, usar una imagen predeterminada
  return raffle.value.image ? `/storage/${raffle.value.image}` : '/assets/media/auth/Letra-Gananza.svg';
});


/** Computed property para los estilos basados en el modo oscuro */
const theme = computed(() => ({
  cardBackground: isDarkMode.value ? 'bg-[#1c1c1e] shadow-lg' : 'bg-[#f9f9f9]',
  modalBackground: isDarkMode.value ? 'bg-[#2c2c2e]' : 'bg-white',
  textPrimary: isDarkMode.value ? 'text-white' : 'text-gray-900',
  textSecondary: isDarkMode.value ? 'text-gray-400' : 'text-gray-700',
  buttonPrimary: isDarkMode.value ? 'bg-blue-700 text-white' : 'bg-blue-600 text-white',
  buttonDanger: isDarkMode.value ? 'bg-red-700 text-white' : 'bg-red-500 text-white',
}));

const openPaymentModal = () => {
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
};

const openVerificationModal = () => {
  showModal.value = false;
  showVerificationModal.value = true;
};

const closeVerificationModal = () => {
  showVerificationModal.value = false;
};

/** Función para validar el pago */
const validatePayment = async () => {
  try {
    alert("Validando el pago, por favor espera...");
    console.log("Número de comprobante ingresado:", referenceNumber.value);
    console.log("Monto ingresado:", raffle.value.ticket_price);

    const response = await axios.post('/verify-payment', {
      referenceNumber: referenceNumber.value,
      monto: raffle.value.ticket_price,
    });

    console.log("Respuesta del servidor:", response.data);
    alert(response.data.message);

    if (response.data.status === 'success') {
      closeVerificationModal();
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

.btn-nequi {
  display: flex;
  align-items: center;
  padding: 12px 24px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: bold;
}

.btn-nequi:hover {
  background-color: #5a00cc;
}

.qr {
  width: 300px;
  height: 300px;
}
</style>
