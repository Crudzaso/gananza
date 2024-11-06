<template>
    <NavBar />
    <Aside />

</template>
<script>
import { router } from '@inertiajs/vue3';
import Aside from '@/Components/aside.vue';
import NavBar from '@/Components/NavBar.vue';

export default {
    methods: {
        logout() {
            router.post(route('logout'));
        }
    }
};
</script>