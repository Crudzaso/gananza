<template>
    <NavBar />
    <Aside />

</template>
<script>
import { router } from '@inertiajs/vue3';
import NavBar from '@/Components/Dashboard/NavBar.vue';

export default {
    methods: {
        logout() {
            router.post(route('logout'));
        }
    }
};
</script>