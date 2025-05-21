<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, Save } from 'lucide-vue-next';

// Tambahkan interface Peminjam
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
        <div class="flex min-h-screen flex-col gap-6 rounded-xl bg-gradient-to-br from-blue-50 via-white to-blue-100 p-6 shadow-lg dark:from-slate-800 dark:via-slate-900 dark:to-slate-800">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-blue-800 dark:text-blue-400">Edit Data Peminjam</h1>
                <Link
                    href="/peminjam"
                    class="flex items-center gap-2 text-blue-600 transition hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
                >
                    <ArrowLeft class="h-5 w-5" />
                    <span class="font-semibold">Kembali</span>
                </Link>
            </div>

            <!-- Form -->
            <div class="rounded-xl bg-white/50 backdrop-blur-sm p-6 shadow-md dark:bg-slate-800/50">
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Form fields -->
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
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
                                class="mt-1 block w-full rounded-lg border border-blue-300 bg-white/50 px-4 py-2 text-sm shadow-sm backdrop-blur-sm transition focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-blue-500/30 dark:bg-slate-800/50 dark:text-white dark:placeholder-blue-400/50"
                                placeholder="Masukkan nama siswa"
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
                                class="mt-1 block w-full rounded-lg border border-blue-300 bg-white/50 px-4 py-2 text-sm shadow-sm backdrop-blur-sm transition focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-blue-500/30 dark:bg-slate-800/50 dark:text-white dark:placeholder-blue-400/50"
                                placeholder="Masukkan kelas"
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
                                class="mt-1 block w-full rounded-lg border border-blue-300 bg-white/50 px-4 py-2 text-sm shadow-sm backdrop-blur-sm transition focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-blue-500/30 dark:bg-slate-800/50 dark:text-white dark:placeholder-blue-400/50"
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
                                class="mt-1 block w-full rounded-lg border border-blue-300 bg-white/50 px-4 py-2 text-sm shadow-sm backdrop-blur-sm transition focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-blue-500/30 dark:bg-slate-800/50 dark:text-white dark:placeholder-blue-400/50"
                                placeholder="Masukkan nama barang"
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
                                class="mt-1 block w-full rounded-lg border border-blue-300 bg-white/50 px-4 py-2 text-sm shadow-sm backdrop-blur-sm transition focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-blue-500/30 dark:bg-slate-800/50 dark:text-white dark:placeholder-blue-400/50"
                                placeholder="Masukkan jumlah barang"
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
                                class="mt-1 block w-full rounded-lg border border-blue-300 bg-white/50 px-4 py-2 text-sm shadow-sm backdrop-blur-sm transition focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-blue-500/30 dark:bg-slate-800/50 dark:text-white"
                            >
                                <option
                                    v-for="option in statusOptions"
                                    :key="option.value"
                                    :value="option.value"
                                >
                                    {{ option.label }}
                                </option>
                            </select>
                            <p v-if="form.errors.status" class="mt-1 text-sm text-red-500">
                                {{ form.errors.status }}
                            </p>
                        </div>
                    </div>

                    <!-- Keterangan (Full Width) -->
                    <div>
                        <label for="keterangan" class="block text-sm font-medium text-blue-700 dark:text-blue-400">
                            Keterangan
                        </label>
                        <input
                            id="keterangan"
                            v-model="form.keterangan"
                            type="text"
                            class="mt-1 block w-full rounded-lg border border-blue-300 bg-white/50 px-4 py-2 text-sm shadow-sm backdrop-blur-sm transition focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-blue-500/30 dark:bg-slate-800/50 dark:text-white dark:placeholder-blue-400/50"
                            placeholder="Masukkan keterangan"
                        />
                        <p v-if="form.errors.keterangan" class="mt-1 text-sm text-red-500">
                            {{ form.errors.keterangan }}
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="flex items-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-2 font-semibold text-white shadow-md transition hover:from-blue-700 hover:to-blue-600 active:scale-95 dark:from-blue-500 dark:to-blue-400 dark:hover:from-blue-400 dark:hover:to-blue-300"
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
