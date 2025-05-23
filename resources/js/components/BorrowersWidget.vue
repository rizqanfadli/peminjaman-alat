<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'

const activeBorrowers = ref(0)

const fetchActiveBorrowers = async () => {
    try {
        const response = await router.get('/active-borrowers')
        activeBorrowers.value = response.data.count
    } catch (error) {
        console.error('Error fetching active borrowers:', error)
    }
}

// Fetch initial data
onMounted(() => {
    fetchActiveBorrowers()
    // Update every 30 seconds
    setInterval(fetchActiveBorrowers, 30000)
})
</script>

<template>
    <div class="h-full p-6 flex flex-col justify-between">
        <div class="space-y-2">
            <h3 class="text-gray-500 text-sm font-medium">Peminjam Aktif</h3>
            <div class="flex items-center space-x-2">
                <span class="text-3xl font-bold text-blue-600">{{ activeBorrowers }}</span>
                <span class="text-sm text-gray-500">orang</span>
            </div>
        </div>
        <div class="flex items-center text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
            </svg>
            <span class="ml-2 text-sm">Belum Mengembalikan</span>
        </div>
    </div>
</template>