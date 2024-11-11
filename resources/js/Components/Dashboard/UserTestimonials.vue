<template>
    <section :class="['testimonials-section my-8', theme.sectionBackground]">
      <h2 :class="['text-2xl font-bold mb-4 text-center', theme.textPrimary]">Testimonios de Usuarios</h2>
      <p :class="['text-lg mb-6 text-center', theme.textSecondary]">
        Descubre lo que dicen los organizadores exitosos sobre nuestra plataforma
      </p>
  
      <!-- Slider de Testimonios -->
      <Splide :options="splideOptions" class="testimonials-slider">
        <SplideSlide
          v-for="(testimonial, index) in testimonials"
          :key="index"
          class="testimonial-slide"
        >
          <div :class="['testimonial-card p-6 rounded-lg shadow-lg', theme.cardBackground]">
            <div class="flex items-center gap-4 mb-4">
              <img
                :src="testimonial.avatar"
                alt="Avatar"
                class="w-12 h-12 rounded-full object-cover"
              />
              <div>
                <h3 :class="['text-lg font-semibold', theme.textPrimary]">{{ testimonial.name }}</h3>
                <div class="flex">
                  <Star
                    v-for="n in testimonial.rating"
                    :key="n"
                    :size="20"
                    :fill="theme.emphasis"
                    :color="theme.emphasis"
                  />
                </div>
              </div>
            </div>
            <p :class="['text-base', theme.textSecondary]">
              "{{ testimonial.text }}"
            </p>
          </div>
        </SplideSlide>
      </Splide>
    </section>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  import { Splide, SplideSlide } from '@splidejs/vue-splide';
  import { useDarkMode } from '@/composables/useDarkMode';
  import { Star } from 'lucide-vue-next';
  
  const { isDarkMode } = useDarkMode();
  
  const testimonials = ref([
    {
      name: 'Ana Gómez',
      rating: 5,
      text: 'Organizar mi rifa fue muy fácil y los resultados fueron increíbles. ¡Recomiendo Gananza!',
      avatar: '/assets/media/gananza/user-light.svg',
    },
    {
      name: 'Carlos Martínez',
      rating: 4,
      text: 'La plataforma es segura y confiable. Mis participantes quedaron muy contentos.',
      avatar: '/assets/media/gananza/user-light.svg',
    },
    {
      name: 'Lucía Fernández',
      rating: 5,
      text: 'El mejor lugar para organizar rifas. El soporte al cliente es excelente.',
      avatar: '/assets/media/gananza/user-light.svg',
    },
  ]);
  
  const splideOptions = {
    type: 'loop',
    perPage: 1,
    autoplay: true,
    interval: 6000,
    speed: 1500,
    arrows: false, // Eliminamos las flechas de navegación
    pagination: true,
    gap: '2rem', // Más espacio entre slides
  };
  
  const theme = computed(() => ({
    sectionBackground: isDarkMode.value ? 'bg-[#1a1a1c]' : 'bg-[#F5F5F7] shadow-sm',
    textPrimary: isDarkMode.value ? 'text-white' : 'text-gray-900',
    textSecondary: isDarkMode.value ? 'text-gray-400' : 'text-gray-700',
    cardBackground: isDarkMode.value ? 'bg-[#1c1c1e] shadow-lg' : 'bg-white shadow-md',
    emphasis: isDarkMode.value ? '#FFD700' : '#FFC107',
  }));
  </script>
  
  <style scoped>
  .testimonials-section {
    padding: 3rem;
    min-height: 300px; /* Incrementamos la altura mínima para evitar mezcla con los controles */
    border-radius: 12px;
    transition: background-color 0.3s ease-in-out;
  }
  
  .testimonials-slider {
    overflow: hidden;
  }
  
  .testimonial-slide {
    display: flex;
    justify-content: center;
    align-items: center;
    animation: fadeInUp 1s ease;
  }
  
  .testimonial-card {
    max-width: 450px;
    transition: transform 0.2s;
  }
  
  .testimonial-card:hover {
    transform: translateY(-5px);
  }
  
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  </style>
  