<script setup>
import { ref, onMounted, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import { Trophy, ArrowUpRight, Calendar, Clock } from 'lucide-vue-next';

const props = defineProps({
    theme: {
        type: Object,
        required: true
    }
});

const lotteryResults = ref([]);
const isLoading = ref(true);
const selectedLottery = ref(null);

const cardStyle = computed(() => ({
    background: props.theme.cardBackground,
    borderColor: props.theme.border,
    boxShadow: '0px 4px 12px rgba(0, 0, 0, 0.1)',
}));

const fetchLotteryResults = async () => {
    try {
        const response = await fetch('https://apilotteries.onrender.com/api/lotteries');
        const data = await response.json();
        lotteryResults.value = data.data.slice(0, 11).map(lottery => ({
            name: lottery.firstH1,
            latestNumber: lottery.ultimoResultado,
            url: lottery.url,
            history: lottery.tablaLoteria.map(result => ({
                date: result[1],
                number: result[2]
            }))
        }));

        if (lotteryResults.value.length > 0) {
            selectedLottery.value = lotteryResults.value[0];
        }
    } catch (error) {
        console.error('Error fetching lottery results:', error);
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => {
    fetchLotteryResults();
});
</script>

<template>
    <div class="min-h-screen" :style="{ background: theme.background }">

        <Head title="Resultados de Lotería" />

        <!-- Header Section -->
        <div class="py-16 px-8 bg-gradient-to-br from-blue-700 to-blue-500 text-white">
            <div class="text-center">
                <h1 class="text-5xl font-extrabold mb-4">Resultados de Lotería</h1>
                <p class="text-lg">Consulta los últimos resultados y números ganadores en tiempo real</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-full mx-auto px-6 py-12">
            <!-- Loading State -->
            <div v-if="isLoading" class="text-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-blue-500 mx-auto mb-4"></div>
                <p :style="{ color: theme.textSecondary }">Cargando resultados...</p>
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Lottery List -->
                <div v-for="lottery in lotteryResults" :key="lottery.url" :class="[
                    'p-6 rounded-xl transition-all duration-300 cursor-pointer',
                    { 'border-4 border-blue-500 bg-white shadow-lg': selectedLottery?.url === lottery.url },
                    'hover:shadow-xl hover:scale-105'
                ]" :style="cardStyle" @click="selectedLottery = lottery">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 :style="{ color: theme.textPrimary }" class="text-xl font-semibold">{{ lottery.name }}
                            </h3>
                            <p :style="{ color: theme.emphasis }" class="text-3xl font-bold">{{ lottery.latestNumber }}
                            </p>
                        </div>
                        <Trophy :size="28" :color="theme.primary" />
                    </div>
                </div>
            </div>

            <!-- Detailed Results Section (Full Width) -->
            <div v-if="selectedLottery" class="mt-12 mx-auto max-w-full px-6 py-8 bg-white rounded-xl shadow-xl"
                :style="{ borderColor: theme.border, boxShadow: '0px 8px 24px rgba(0, 0, 0, 0.15)' }">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-3xl font-bold text-blue-800 mb-2">{{ selectedLottery.name }}</h2>
                        <p class="flex items-center gap-2 text-blue-600">
                            <Clock class="text-blue-500" /> Último resultado
                        </p>
                    </div>
                    <a :href="selectedLottery.url" target="_blank"
                        class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg shadow-lg transition-transform duration-200 hover:scale-105">
                        Ver más
                        <ArrowUpRight />
                    </a>
                </div>

                <!-- Results History -->
                <div>
                    <h3 class="text-2xl font-semibold text-blue-800 mb-4">Historial de Resultados</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div v-for="(result, index) in selectedLottery.history" :key="index"
                            class="p-4 rounded-lg flex items-center justify-between bg-blue-50">
                            <div class="flex items-center gap-3">
                                <Calendar class="text-blue-400" />
                                <span class="text-blue-600">{{ result.date }}</span>
                            </div>
                            <span class="text-2xl font-bold text-blue-700">{{ result.number }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
