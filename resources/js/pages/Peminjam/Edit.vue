<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, Save } from 'lucide-vue-next';

interface Peminjam {
  id: number;
  nama_siswa: string;
  kelas: string;
  tanggal_peminjaman: string;
  nama_barang: string;
  jumlah_barang: number;
  keterangan: string;
  status: string;
}

const props = defineProps<{
  peminjam: Peminjam;
}>();

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Data Peminjam', href: '/peminjam' },
  { title: 'Edit Peminjam', href: `/peminjam/${props.peminjam.id}/edit` },
];

const form = useForm({
  nama_siswa: props.peminjam.nama_siswa,
  kelas: props.peminjam.kelas,
  tanggal_peminjaman: props.peminjam.tanggal_peminjaman,
  nama_barang: props.peminjam.nama_barang,
  jumlah_barang: props.peminjam.jumlah_barang,
  keterangan: props.peminjam.keterangan,
  status: props.peminjam.status,
});

const statusOptions = [
  { value: 'Dipinjam', label: 'Dipinjam' },
  { value: 'Sudah Dikembalikan', label: 'Sudah Dikembalikan' },
];

function submit() {
  form.put(route('peminjam.update', props.peminjam.id));
}
</script>

<template>
  <Head title="Edit Peminjam" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div
      class="flex min-h-screen flex-col gap-6 rounded-xl bg-gradient-to-br from-blue-50 via-white to-blue-100 p-6 font-[Poppins] shadow-lg dark:from-slate-800 dark:via-slate-900 dark:to-slate-800 dark:text-gray-100"
    >
      <!-- Judul Besar -->
      <h1 class="text-2xl font-bold text-blue-800 dark:text-white">
        Edit Data Peminjam
      </h1>

      <!-- Form -->
      <div
        class="mx-auto w-full max-w-4xl rounded-xl border border-blue-200 bg-white p-8 shadow-md dark:border-slate-700 dark:bg-slate-800"
      >
        <form @submit.prevent="submit" class="space-y-6">
          <!-- Nama Siswa -->
          <div>
            <label for="nama_siswa" class="block text-sm font-medium text-blue-700 dark:text-blue-400">
              Nama Siswa
            </label>
            <input
              id="nama_siswa"
              v-model="form.nama_siswa"
              type="text"
              required
              class="mt-1 block w-full rounded-md border border-blue-300 px-4 py-2 shadow-sm transition focus:border-blue-500 focus:ring focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            />
            <p v-if="form.errors.nama_siswa" class="mt-1 text-sm text-red-500">
              {{ form.errors.nama_siswa }}
            </p>
          </div>

          <!-- Kelas -->
          <div>
            <label for="kelas" class="block text-sm font-medium text-blue-700 dark:text-blue-400">
              Kelas
            </label>
            <input
              id="kelas"
              v-model="form.kelas"
              type="text"
              required
              class="mt-1 block w-full rounded-md border border-blue-300 px-4 py-2 shadow-sm transition focus:border-blue-500 focus:ring focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            />
            <p v-if="form.errors.kelas" class="mt-1 text-sm text-red-500">
              {{ form.errors.kelas }}
            </p>
          </div>

          <!-- Tanggal Peminjaman -->
          <div>
            <label for="tanggal_peminjaman" class="block text-sm font-medium text-blue-700 dark:text-blue-400">
              Tanggal Peminjaman
            </label>
            <input
              id="tanggal_peminjaman"
              v-model="form.tanggal_peminjaman"
              type="date"
              required
              class="mt-1 block w-full rounded-md border border-blue-300 px-4 py-2 shadow-sm transition focus:border-blue-500 focus:ring focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            />
            <p v-if="form.errors.tanggal_peminjaman" class="mt-1 text-sm text-red-500">
              {{ form.errors.tanggal_peminjaman }}
            </p>
          </div>

          <!-- Nama Barang -->
          <div>
            <label for="nama_barang" class="block text-sm font-medium text-blue-700 dark:text-blue-400">
              Nama Barang
            </label>
            <input
              id="nama_barang"
              v-model="form.nama_barang"
              type="text"
              required
              class="mt-1 block w-full rounded-md border border-blue-300 px-4 py-2 shadow-sm transition focus:border-blue-500 focus:ring focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            />
            <p v-if="form.errors.nama_barang" class="mt-1 text-sm text-red-500">
              {{ form.errors.nama_barang }}
            </p>
          </div>

          <!-- Jumlah Barang -->
          <div>
            <label for="jumlah_barang" class="block text-sm font-medium text-blue-700 dark:text-blue-400">
              Jumlah Barang
            </label>
            <input
              id="jumlah_barang"
              v-model="form.jumlah_barang"
              type="number"
              required
              class="mt-1 block w-full rounded-md border border-blue-300 px-4 py-2 shadow-sm transition focus:border-blue-500 focus:ring focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            />
            <p v-if="form.errors.jumlah_barang" class="mt-1 text-sm text-red-500">
              {{ form.errors.jumlah_barang }}
            </p>
          </div>

          <!-- Status -->
          <div>
            <label for="status" class="block text-sm font-medium text-blue-700 dark:text-blue-400">
              Status
            </label>
            <select
              id="status"
              v-model="form.status"
              required
              class="mt-1 block w-full rounded-md border border-blue-300 px-4 py-2 shadow-sm transition focus:border-blue-500 focus:ring focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            >
              <option v-for="option in statusOptions" :key="option.value" :value="option.value">
                {{ option.label }}
              </option>
            </select>
            <p v-if="form.errors.status" class="mt-1 text-sm text-red-500">
              {{ form.errors.status }}
            </p>
          </div>

          <!-- Keterangan -->
          <div>
            <label for="keterangan" class="block text-sm font-medium text-blue-700 dark:text-blue-400">
              Keterangan
            </label>
            <input
              id="keterangan"
              v-model="form.keterangan"
              type="text"
              class="mt-1 block w-full rounded-md border border-blue-300 px-4 py-2 shadow-sm transition focus:border-blue-500 focus:ring focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            />
            <p v-if="form.errors.keterangan" class="mt-1 text-sm text-red-500">
              {{ form.errors.keterangan }}
            </p>
          </div>

          <!-- Tombol Aksi -->
          <div class="mt-8 flex items-center justify-between">
            <Link
              href="/peminjam"
              class="flex items-center gap-2 text-blue-600 transition hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
            >
              <ArrowLeft class="h-5 w-5" />
              <span class="font-semibold">Kembali</span>
            </Link>

            <button
              type="submit"
              class="flex items-center gap-2 rounded-lg bg-blue-600 px-6 py-2 font-semibold text-white shadow-md transition hover:bg-blue-700 active:scale-95 dark:bg-blue-500 dark:hover:bg-blue-400"
              :disabled="form.processing"
            >
              <Save class="h-5 w-5" />
              Simpan Perubahan
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>
