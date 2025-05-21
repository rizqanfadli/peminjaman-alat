<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { ArrowLeft, Save } from 'lucide-vue-next';

interface Barang {
  id: number;
  nama_barang: string;
  gambar_barang: string;
  jumlah_barang: number;
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Edit Barang',
    href: '/barang',
  },
];

const props = defineProps<{
  data_barang: Barang;
}>();

const form = useForm({
  nama_barang: props.data_barang.nama_barang,
  gambar_barang: props.data_barang.gambar_barang,
  jumlah_barang: props.data_barang.jumlah_barang,
});

function submit() {
  form.put(route('barang.update', props.data_barang.id), {
    preserveScroll: true,
  });
}
</script>

<template>
  <Head title="Edit Barang" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div
      class="mx-auto w-full max-w-4xl rounded-xl border border-blue-200 bg-gradient-to-b from-blue-50 via-white to-white p-8 shadow-md transition dark:border-gray-700 dark:from-gray-900 dark:via-gray-950 dark:to-gray-900 dark:text-gray-100"
    >
      <form @submit.prevent="submit" class="space-y-6">
        <!-- Nama Barang -->
        <div>
          <Label
            for="nama_barang"
            class="font-semibold text-blue-700 dark:text-blue-300"
            >Nama Barang</Label
          >
          <Input
            id="nama_barang"
            type="text"
            class="mt-1 block w-full rounded-md border border-blue-300 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            v-model="form.nama_barang"
            placeholder="Masukkan nama barang"
          />
          <InputError
            class="mt-2 text-red-600 dark:text-red-400"
            :message="form.errors.nama_barang"
          />
        </div>

        <!-- Jumlah Barang -->
        <div>
          <Label
            for="jumlah_barang"
            class="font-semibold text-blue-700 dark:text-blue-300"
            >Jumlah Barang</Label
          >
          <Input
            id="jumlah_barang"
            type="number"
            class="mt-1 block w-full rounded-md border border-blue-300 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            v-model="form.jumlah_barang"
            placeholder="Masukkan jumlah barang"
          />
          <InputError
            class="mt-2 text-red-600 dark:text-red-400"
            :message="form.errors.jumlah_barang"
          />
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-8 flex items-center justify-between">
          <Link
            href="/barang"
            class="flex items-center gap-2 text-blue-600 transition hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
          >
            <ArrowLeft class="h-5 w-5" />
            <span class="font-semibold">Kembali</span>
          </Link>

          <Button
            type="submit"
            class="flex items-center gap-2 rounded-lg bg-blue-600 px-6 py-2 font-semibold text-white shadow-md transition hover:bg-blue-700 active:scale-95 dark:bg-blue-500 dark:hover:bg-blue-400"
            :disabled="form.processing"
          >
            <Save class="h-5 w-5" />
            Simpan Perubahan
          </Button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
