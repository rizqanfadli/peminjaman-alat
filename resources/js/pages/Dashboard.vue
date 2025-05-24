<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import ActiveBorrowersWidget from '../components/ActiveBorrowersWidget.vue';
import BorrowersChartWidget from '../components/BorrowersChartWidget.vue';

defineProps<{
  activeBorrowers: number,
  monthlyBorrowers: { month: string; count: number; }[]
}>();

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Admin', href: '/admin' },
];
</script>

<template>
  <Head title="Admin" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex min-h-screen flex-col gap-6 rounded-xl bg-gradient-to-br from-blue-50 via-white to-blue-100 p-6 shadow-lg dark:from-slate-800 dark:via-slate-900 dark:to-slate-800 font-[Poppins]">
      <!-- Header -->
      <h1 class="text-2xl font-semibold text-blue-800 dark:text-white">Dashboard Admin</h1>

      <!-- Kartu Statistik -->
      <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="relative aspect-video overflow-hidden rounded-2xl border border-blue-200 bg-white shadow-md transition-all hover:shadow-lg dark:bg-slate-800 dark:border-slate-700">
          <ActiveBorrowersWidget :initial-count="activeBorrowers" />
        </div>

        <div class="relative aspect-video overflow-hidden rounded-2xl border border-blue-200 bg-white shadow-md transition-all hover:shadow-lg dark:bg-slate-800 dark:border-slate-700">
          <!-- <PlaceholderPattern /> -->
        </div>

        <div class="relative aspect-video overflow-hidden rounded-2xl border border-blue-200 bg-white shadow-md transition-all hover:shadow-lg dark:bg-slate-800 dark:border-slate-700">
          <!-- <PlaceholderPattern /> -->
        </div>
      </div>

      <!-- Panel Besar -->
      <div class="relative min-h-[400px] rounded-2xl border border-blue-200 bg-white p-4 shadow-md transition-all hover:shadow-lg dark:bg-slate-800 dark:border-slate-700">
        <BorrowersChartWidget :monthly-data="monthlyBorrowers" />
      </div>
    </div>
  </AppLayout>
</template>
