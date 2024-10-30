<template>
  <div class="  " >
    <nav class="flex w-full items-center justify-between rounded-lg bg-[#2A2B3C] p-6">
      <div class="flex flex-col">
        <h1 class="text-2xl font-semibold text-white">Dashboard</h1>
        <p class="text-sm text-gray-400">Bienvenido </p>
      </div>

      <div class="flex items-center gap-4">
        <div class="relative">
          <input
            type="search"
            placeholder="Find Goods"
            class="w-64 rounded-md bg-[#363748] pl-9 pr-3 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 transform text-gray-400"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>

        <div class="flex items-center gap-3">
          <button
            v-for="(button, index) in buttons"
            :key="index"
            class="relative rounded-full p-2 text-gray-400 hover:bg-[#363748] focus:outline-none focus:ring-2 focus:ring-blue-500"
            :aria-label="button.label"
          >
            <component :is="button.icon" class="h-5 w-5" />
          </button>

          <button
            class="relative rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            New Goal
          </button>
        </div>
      </div>
    </nav>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const buttons = ref([
  {
    icon: {
      template: `
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
      `
    },
    label: 'Notifications'
  },
  {
    icon: {
      template: `
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
      `
    },
    label: 'Profile'
  },
  {
    icon: {
      template: `
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
      `
    },
    label: 'Toggle theme'
  }
])
</script>