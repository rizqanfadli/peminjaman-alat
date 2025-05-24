<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps<{
  initialCount: number
}>();

const borrowersCount = ref(props.initialCount);

const refreshCount = () => {
  router.reload({ only: ['activeBorrowers'] });
};

onMounted(() => {
  // Refresh setiap 30 detik
  setInterval(refreshCount, 30000);
});
</script>

<template>
  <div class="w-full h-full p-4 rounded-xl bg-white text-blue-800 border border-blue-200 dark:bg-slate-800 dark:text-white dark:border-slate-700">
    <div class="flex flex-col h-full justify-between">
      <div>
        <h3 class=" text-sm font-medium mb-2">Total Peminjam Aktif</h3>
        <div class="flex items-baseline">
          <span class="text-6xl font-bold text-blue-600">{{ borrowersCount }}</span>
          <span class="ml-2 text-sm">peminjam</span>
        </div>
      </div>
      
      <div class="flex items-center text-blue-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
        </svg>
        <span class="ml-2 text-sm">Status Dipinjam</span>
      </div>
    </div>
  </div>
</template>