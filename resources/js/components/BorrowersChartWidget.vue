<script setup lang="ts">
import { ref, onMounted } from 'vue';
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

  if (chart) {
    chart.destroy(); // Hapus chart lama jika ada
  }

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
        pointRadius: 4,
        pointHoverRadius: 6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: false,
      plugins: {
        title: {
          display: true,
          text: 'Grafik Peminjam Per Bulan',
          color: document.documentElement.classList.contains('dark') ? '#fff' : '#1e40af',
          font: {
            size: 16,
            family: 'Poppins'
          }
        },
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1,
            precision: 0,
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

onMounted(() => {
  createChart();
});
</script>

<template>
  <div class="w-full h-full">
    <canvas ref="chartCanvas"></canvas>
  </div>
</template>