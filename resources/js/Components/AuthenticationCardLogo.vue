<script setup>
import { Link } from '@inertiajs/vue3';
import MyIcon from '../../../public/Gananza.svg'; // Cambia la ruta según donde esté tu SVG
</script>

<template>
    <Link :href="'/'">
        <img :src="MyIcon" class="w-16 h-16" alt="My Custom Icon" />
    </Link>
</template>
