<template>
  <section :class="['last-chance-raffles my-8', theme.sectionBackground]">
    <h2 :class="['text-2xl font-bold mb-6 text-center flex items-center justify-center', theme.textPrimary]">
      <img :src="iconSrc" class="h-8 w-8 mr-2" />
      Última Oportunidad
    </h2>
    <!-- Slider de Rifas -->
    <Splide :options="splideOptions" class="splide-slider overflow-visible">
      <SplideSlide
        v-for="raffle in lastChanceRaffles"
        :key="raffle.id"
        class="raffle-slide"
      >
        <div class="flex justify-center">
          <RaffleCard :raffle="raffle" />
        </div>
      </SplideSlide>
    </Splide>
  </section>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { Splide, SplideSlide } from '@splidejs/vue-splide';
import RaffleCard from './RaffleCard.vue';
import { useDarkMode } from '@/composables/useDarkMode';

const { isDarkMode } = useDarkMode();

const iconSrc = computed(() =>
  isDarkMode.value ? '/assets/media/gananza/warning-light.svg' : '/assets/media/gananza/warning-dark.svg'
);

const lastChanceRaffles = ref([]);
const splideOptions = {
  type: 'loop',
  perPage: 3,
  autoplay: true,
  interval: 7000,
  speed: 1800,
  arrows: true,
  pagination: true,
  padding: '1rem',
  gap: '1.5rem', // Espacio entre slides
  breakpoints: {
    1024: { perPage: 2 },
    768: { perPage: 1 },
  },
};

const fetchLastChanceRaffles = async () => {
  try {
    const response = await fetch('/raffles-last-chance');
    if (!response.ok) {
      throw new Error('Error al obtener rifas de última oportunidad');
    }
    lastChanceRaffles.value = await response.json();
  } catch (error) {
    console.error('Error fetching last chance raffles:', error);
  }
};

const theme = computed(() => ({
  sectionBackground: isDarkMode.value
    ? 'bg-[#1a1a1c] shadow-lg'
    : 'bg-[#F5F5F7] shadow-sm',
  textPrimary: isDarkMode.value ? 'text-white' : 'text-gray-900',
  raffleSlideBorder: isDarkMode.value ? 'border-gray-700' : 'border-gray-300',
  splideArrow: isDarkMode.value ? 'bg-blue-700' : 'bg-blue-600',
  splideArrowHover: isDarkMode.value ? 'hover:bg-blue-800' : 'hover:bg-blue-700',
}));
  
onMounted(() => fetchLastChanceRaffles());
</script>

<style scoped>
.last-chance-raffles {
  padding: 1rem;
  border-radius: 12px;
  transition: background-color 0.3s ease-in-out;
}

.splide-slider {
  overflow: visible;
}

.raffle-slide {
  display: flex;
  justify-content: center;
  align-items: center;
  transition: transform 0.2s;
  padding: 1rem
}

/* Estilo de hover para las tarjetas */
.raffle-slide:hover {
  transform: translateY(-5px);
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
</style>
