<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

const props = defineProps<{
  monthlyData: {
    month: string;
    count: number;
  }[]
}>();

const chartCanvas = ref<HTMLCanvasElement | null>(null);
let chart: Chart | null = null;

const createChart = () => {
  if (!chartCanvas.value) return;

  const ctx = chartCanvas.value.getContext('2d');
  if (!ctx) return;

  chart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: props.monthlyData.map(item => item.month),
      datasets: [{
        label: 'Jumlah Peminjam',
        data: props.monthlyData.map(item => item.count),
        borderColor: '#2563eb',
        backgroundColor: 'rgba(37, 99, 235, 0.1)',
        fill: true,
        tension: 0.4,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        title: {
          display: true,
          text: 'Grafik Peminjam Per Bulan',
          color: document.documentElement.classList.contains('dark') ? '#fff' : '#1e40af',
          font: {
            size: 16,
            family: 'Poppins'
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            color: document.documentElement.classList.contains('dark') ? '#fff' : '#1e40af'
          }
        },
        x: {
          ticks: {
            color: document.documentElement.classList.contains('dark') ? '#fff' : '#1e40af'
          }
        }
      }
    }
  });
};

const refreshData = () => {
  router.reload({ only: ['monthlyBorrowers'] });
};

watch(() => props.monthlyData, () => {
  if (chart) {
    chart.destroy();
  }
  createChart();
}, { deep: true });

onMounted(() => {
  createChart();
  // Refresh setiap 30 detik
  setInterval(refreshData, 30000);
});
</script>

<template>
  <div class="w-full h-full">
    <canvas ref="chartCanvas"></canvas>
  </div>
</template>