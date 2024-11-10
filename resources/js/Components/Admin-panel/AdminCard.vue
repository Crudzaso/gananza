<template>
    <a :href="href" class="admin-card" :class="[bgColor, textColor]">
        <div class="content-wrapper">
            <div class="icon-container">
                <i :class="['fas', icon]"></i>
            </div>
            <span class="card-title">{{ title }}</span>
        </div>
    </a>
</template>

<script setup>
import { computed } from 'vue';
import { useDarkMode } from '@/composables/useDarkMode';

const props = defineProps({
    href: String,
    icon: String,
    title: String,
    color: String,
});

const { isDarkMode } = useDarkMode();
const bgColor = computed(() => {
    const colorMap = {
        blue: isDarkMode.value ? 'bg-blue-700' : 'bg-blue-500',
        green: isDarkMode.value ? 'bg-green-700' : 'bg-green-500',
        yellow: isDarkMode.value ? 'bg-yellow-600' : 'bg-yellow-400',
        red: isDarkMode.value ? 'bg-red-700' : 'bg-red-500',
        purple: isDarkMode.value ? 'bg-purple-700' : 'bg-purple-500',
        indigo: isDarkMode.value ? 'bg-indigo-700' : 'bg-indigo-500',
        teal: isDarkMode.value ? 'bg-teal-700' : 'bg-teal-500',
    };
    return colorMap[props.color] || 'bg-gray-500';
});

const textColor = computed(() => (isDarkMode.value ? 'text-white' : 'text-gray-800'));
</script>

<style scoped>
.admin-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    transition: transform 0.2s, box-shadow 0.2s;
    cursor: pointer;
}

.admin-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

.content-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}

.icon-container {
    font-size: 4rem; /* Aumenta el tamaño del icono */
    margin-bottom: 1rem;
    opacity: 0.9;
}

.card-title {
    font-size: 1.2rem;
    font-weight: 600;
    text-align: center;
}

</style>
