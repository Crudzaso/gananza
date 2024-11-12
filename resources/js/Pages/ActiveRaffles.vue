<template>
    <div :style="{ background: theme.background }"
        class="flex flex-col justify-between h-screen w-screen p-8 transition-colors duration-500">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 :style="{ color: theme.textPrimary }" class="text-5xl font-extrabold mb-4">🎟️ Rifas Exclusivas</h1>
            <p :style="{ color: theme.textSecondary }" class="text-xl mb-6">
                Participa en rifas únicas y gana premios increíbles. ¡No te lo pierdas!
            </p>
            <div class="flex flex-col md:flex-row justify-center gap-4">
                <a href="/dashboard">
                    <button :class="theme.buttonPrimary" class="px-8 py-4 rounded-lg shadow-md transition">Ir al
                        Dashboard</button>
                </a>
                <button @click="openFilterModal" :style="{ background: theme.cardBackground, color: theme.textPrimary }"
                    class="px-8 py-4 rounded-lg shadow-md transition">Filtros Manuales</button>
            </div>
        </div>

        <!-- Secciones Title -->
        <div class="text-center mb-12">
            <div class="flex justify-center items-center mb-4">
                <span :style="{ background: theme.textPrimary }" class="inline-block w-16 h-1 rounded-full"></span>
                <h2 :style="{ color: theme.textPrimary }" class="text-4xl font-bold mx-4">✨ Explora nuestras categorías
                </h2>
                <span :style="{ background: theme.textPrimary }" class="inline-block w-16 h-1 rounded-full"></span>
            </div>
            <p :style="{ color: theme.textSecondary }" class="text-lg mb-4">
                Descubre nuestras diferentes secciones para encontrar la rifa que mejor se adapte a ti.
            </p>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-4">
            <button v-for="(section, index) in sections" :key="index"
                :style="{ background: theme.cardBackground, color: theme.textPrimary }"
                class="rounded-3xl p-12 shadow-lg hover:shadow-2xl transition-transform transform hover:-translate-y-2"
                @click="fetchRaffles(section.filter)">
                <div class="flex flex-col items-center">
                    <div v-if="section.title === 'Rifas Populares'" class="mb-6">
                        <img src="../../../public/assets/media/auth/custom-filter.webp" alt="custom-image"
                            class="w-48 h-48 object-cover rounded-lg">
                    </div>
                    <div v-else-if="section.title === 'Rifas Recientes'" class="mb-6">
                        <img src="../../../public/assets/media/auth/cash-salary.webp" alt="cash-image"
                            class="w-48 h-48 object-cover rounded-lg">
                    </div>
                    <div v-else class="mb-6">
                        <img src="../../../public/assets/media/auth/business-research.webp" alt="business-image"
                            class="w-48 h-48 object-cover rounded-lg">
                    </div>
                    <h3 :style="{ color: theme.textPrimary }" class="text-2xl font-semibold mb-2">{{ section.title }}
                    </h3>
                    <p :style="{ color: theme.textSecondary }" class="text-lg mb-4">{{ section.description }}</p>
                    <p :style="{ color: theme.textSecondary }" class="text-sm">¡Haz clic para saber más y participar en
                        esta categoría emocionante!</p>
                </div>
            </button>
        </div>

        <TransitionRoot appear :show="isFilterModalOpen" as="template">
            <Dialog as="div" @close="closeFilterModal"
                class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 scale-95"
                    enter-to="opacity-100 scale-100" leave="ease-in duration-200" leave-from="opacity-100 scale-100"
                    leave-to="opacity-0 scale-95">
                    <DialogPanel :style="{ background: theme.cardBackground }"
                        class="w-full max-w-lg p-8 rounded-3xl shadow-2xl">
                        <DialogTitle :style="{ color: theme.textPrimary }"
                            class="text-3xl font-semibold mb-6 text-center">
                            Filtros Manuales
                        </DialogTitle>
                        <div class="mb-6">
                            <label :style="{ color: theme.textSecondary }" class="block text-lg mb-2">Selecciona una
                                Fecha:</label>
                            <input v-model="selectedDate" type="date"
                                :style="{ background: theme.cardBackground, color: theme.textPrimary }"
                                class="w-full p-3 rounded-lg shadow-md">
                        </div>
                        <div class="mb-6">
                            <label :style="{ color: theme.textSecondary }" class="block text-lg mb-2">Filtrar
                                por:</label>
                            <select v-model="selectedFilter"
                                :style="{ background: theme.cardBackground, color: theme.textPrimary }"
                                class="w-full p-3 rounded-lg shadow-md">
                                <option value="">-- Seleccionar Filtro --</option>
                                <option value="popular">Rifas Populares</option>
                                <option value="last_chance">Última Oportunidad</option>
                                <option value="flash">Rifas Flash</option>
                            </select>
                        </div>
                        <button @click="applyManualFilter" :class="theme.buttonPrimary"
                            class="w-full px-6 py-3 rounded-lg transition">Aplicar Filtro</button>
                    </DialogPanel>
                </TransitionChild>
            </Dialog>
        </TransitionRoot>
        <!-- Modal -->
        <TransitionRoot appear :show="isModalOpen" as="template">
            <Dialog as="div" @close="closeModal"
                class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 scale-95"
                    enter-to="opacity-100 scale-100" leave="ease-in duration-200" leave-from="opacity-100 scale-100"
                    leave-to="opacity-0 scale-95">
                    <DialogPanel :style="{ background: theme.cardBackground }"
                        class="w-full max-w-5xl p-12 rounded-3xl shadow-2xl">
                        <DialogTitle :style="{ color: theme.textPrimary }"
                            class="text-4xl font-semibold mb-8 text-center">
                            {{ selectedSection?.title }}
                        </DialogTitle>

                        <div v-if="loading" class="text-center text-xl" :style="{ color: theme.textSecondary }">Cargando
                            rifas...</div>
                        <div v-else-if="raffles.length === 0" class="text-center text-xl"
                            :style="{ color: theme.textSecondary }">No hay rifas disponibles.</div>

                        <!-- Slider de rifas con Splide -->
                        <Splide :options="splideOptions" class="splide-slider">
                            <SplideSlide v-for="raffle in raffles" :key="raffle.id" class="raffle-slide">
                                <RaffleCard :raffle="raffle" />
                            </SplideSlide>
                        </Splide>

                        <!-- Botón de Cerrar -->
                        <div class="mt-10 text-center">
                            <button :class="theme.buttonPrimary" class="px-8 py-4 rounded-lg transition"
                                @click="closeModal">Cerrar</button>
                        </div>
                    </DialogPanel>
                </TransitionChild>
            </Dialog>
        </TransitionRoot>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';
import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle } from '@headlessui/vue';
import RaffleCard from '../Components/Dashboard/RaffleCard.vue';
import { Splide, SplideSlide } from '@splidejs/vue-splide';
import { useDarkMode } from '@/composables/useDarkMode';

const { isDarkMode } = useDarkMode();

const isModalOpen = ref(false);
const isFilterModalOpen = ref(false);
const selectedSection = ref(null);
const raffles = ref([]);
const loading = ref(false);
const selectedDate = ref('');
const selectedFilter = ref('');

const theme = computed(() => ({
    background: isDarkMode.value ? '#121212' : '#F9FAFB',
    textPrimary: isDarkMode.value ? '#E0E0E0' : '#212121',
    textSecondary: isDarkMode.value ? '#B0BEC5' : '#757575',
    cardBackground: isDarkMode.value ? '#1E1E1E' : '#FFFFFF',
    buttonPrimary: isDarkMode.value ? 'bg-blue-700 text-white hover:bg-blue-800' : 'bg-blue-600 text-white hover:bg-blue-700',
}));

const sections = [
    { title: 'Rifas Populares', description: 'Descubre rifas populares.', filter: 'popular' },
    { title: 'Rifas Recientes', description: 'Las últimas rifas agregadas.', filter: 'flash' },
    { title: 'Última Oportunidad', description: 'Rifas por cerrar.', filter: 'last_chance' },
];



const splideOptions = {
    type: 'loop',
    perPage: 2,
    autoplay: true,
    interval: 5000,
    speed: 1000,
    gap: '1rem',
    arrows: true,
    pagination: true,
    breakpoints: {
        1024: { perPage: 2 },
        768: { perPage: 1 },
    },
};

const openFilterModal = () => {
    isFilterModalOpen.value = true;
};

const closeFilterModal = () => {
    isFilterModalOpen.value = false;
};

const applyManualFilter = async () => {
    closeFilterModal();
    loading.value = true;
    raffles.value = [];
    try {
        const response = await axios.get(`/raffles-filtered?filter=${selectedFilter.value}&date=${selectedDate.value}`);
        raffles.value = response.data.data;
        isModalOpen.value = true;
    } catch (error) {
        console.error('Error al aplicar filtros:', error);
    } finally {
        loading.value = false;
    }
};

const fetchRaffles = async (filter) => {
    loading.value = true;
    raffles.value = [];
    try {
        const response = await axios.get(`/raffles-filtered?filter=${filter}`);
        raffles.value = response.data.data;
        selectedSection.value = sections.find(section => section.filter === filter);
        isModalOpen.value = true;
    } catch (error) {
        console.error('Error al obtener rifas:', error);
    } finally {
        loading.value = false;
    }
};

const closeModal = () => {
    isModalOpen.value = false;
    setTimeout(() => {
        selectedSection.value = null;
        raffles.value = [];
    }, 200);
};
</script>

<style scoped>
.splide-slider {
    padding: 1rem 0;
}

.raffle-slide {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 1rem;
}

.splide__arrow {
    color: #ffffff;
    border-radius: 50%;
    width: 2.5rem;
    height: 2.5rem;
    transition: background-color 0.3s;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.splide__arrow:hover {
    transform: scale(1.15);
}

.splide__pagination {
    margin-top: 1rem;
}

.splide__pagination__page {
    background-color: blue;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    transition: transform 0.2s;
}

.splide__pagination__page.is-active {
    background-color: #ff5733;
    transform: scale(1.2);
}
</style>