<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Pencil, Trash2 } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Data Peminjam', href: '/peminjam' }];

interface Peminjam {
    id: number;
    nama_siswa: string;
    kelas: string;
    tanggal_peminjaman: Date;
    nama_barang: string;
    jumlah_barang: number;
    keterangan: string;
    status: string;
}

const props = defineProps<{
    peminjam: Peminjam[];
}>();

const form = useForm({
    status: '',
});

const statusOptions = [
    { value: 'Dipinjam', label: 'Dipinjam' },
    { value: 'Sudah Dikembalikan', label: 'Sudah Dikembalikan' },
];

const search = ref('');
const startDate = ref('');
const endDate = ref('');
const showDateRangeModal = ref(false);

const filteredPeminjam = computed(() => {
    const keyword = search.value.toLowerCase();
    return props.peminjam.filter((peminjam) => {
        // Filter berdasarkan keyword
        const matchesKeyword =
            peminjam.nama_siswa.toLowerCase().includes(keyword) ||
            peminjam.kelas.toLowerCase().includes(keyword) ||
            peminjam.nama_barang.toLowerCase().includes(keyword);

        // Filter berdasarkan rentang tanggal
        const peminjamDate = new Date(peminjam.tanggal_peminjaman);
        const start = startDate.value ? new Date(startDate.value) : null;
        const end = endDate.value ? new Date(endDate.value) : null;

        const matchesDateRange = (!start || peminjamDate >= start) && (!end || peminjamDate <= end);

        return matchesKeyword && matchesDateRange;
    });
});

function deleteItem(id: number) {
    if (confirm('Apakah anda yakin akan menghapus ini?')) {
        form.delete(route('peminjam.destroy', id), {
            preserveScroll: true,
        });
    }
}

function updateStatus(id: number, newStatus: string) {
    form.status = newStatus;
    form.patch(route('peminjam.updateStatus', id), {
        preserveScroll: true,
        preserveState: true,
    });
}

function exportToCSV() {
    // Header untuk CSV
    const csvHeader = ['No', 'Nama Peminjam', 'Kelas', 'Tanggal Peminjaman', 'Nama Barang', 'Jumlah', 'Keterangan', 'Status'].join(';');

    // Menggunakan filteredPeminjam yang sudah terfilter
    const csvRows = filteredPeminjam.value.map((peminjam, index) => {
        return [
            index + 1,
            peminjam.nama_siswa,
            peminjam.kelas,
            peminjam.tanggal_peminjaman,
            peminjam.nama_barang,
            peminjam.jumlah_barang,
            peminjam.keterangan,
            peminjam.status,
        ].join(';');
    });

    // Menambahkan informasi filter ke nama file
    let fileName = 'data-peminjam';
    if (startDate.value && endDate.value) {
        fileName += `-${startDate.value}-to-${endDate.value}`;
    }
    fileName += '.csv';

    // Gabungkan header dan rows
    const csvString = [csvHeader, ...csvRows].join('\n');

    // Buat Blob dan unduh file
    const blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);

    // Set properti link untuk mengunduh
    link.setAttribute('href', url);
    link.setAttribute('download', fileName);
    link.style.visibility = 'hidden';

    // Tambahkan ke document, klik, dan hapus
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function clearDateFilter() {
    startDate.value = '';
    endDate.value = '';
    showDateRangeModal.value = false;
}

function applyDateFilter() {
    showDateRangeModal.value = false;
}
</script>

<template>
    <Head title="Data Peminjam" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex min-h-screen flex-col gap-6 rounded-xl bg-gradient-to-br from-blue-50 via-white to-blue-100 p-6 font-[Poppins] shadow-lg dark:from-slate-800 dark:via-slate-900 dark:to-slate-800"
        >
            <!-- Header -->
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h1 class="text-2xl font-semibold text-blue-800 dark:text-white">Data Peminjam</h1>
                <div class="flex flex-col items-start gap-2 sm:flex-row sm:items-center">
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Cari nama/kelas/barang..."
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:placeholder-gray-400"
                    />

                    <!-- Tombol Filter Tanggal -->
                    <div class="relative">
                        <button
                            @click="showDateRangeModal = true"
                            class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-white shadow-md transition hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400"
                        >
                            Filter Tanggal
                            <span v-if="startDate && endDate" class="text-xs"> ({{ startDate }} - {{ endDate }}) </span>
                        </button>

                        <!-- Modal akan muncul di sini -->
                    </div>

                    <!-- Modal Filter Tanggal -->
                    <div v-if="showDateRangeModal" class="absolute top-12 right-0 z-50">
                        <div class="w-80 rounded-lg border border-gray-200 bg-white p-6 shadow-xl dark:border-slate-700 dark:bg-slate-800">
                            <div class="mb-4 flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filter Rentang Tanggal</h3>
                                <button
                                    @click="showDateRangeModal = false"
                                    class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
                                >
                                    ✕
                                </button>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dari Tanggal</label>
                                    <input
                                        v-model="startDate"
                                        type="date"
                                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white"
                                    />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sampai Tanggal</label>
                                    <input
                                        v-model="endDate"
                                        type="date"
                                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white"
                                    />
                                </div>
                                <div class="mt-4 flex justify-end gap-2">
                                    <button
                                        @click="clearDateFilter"
                                        class="rounded-lg px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700"
                                    >
                                        Reset
                                    </button>
                                    <button
                                        @click="applyDateFilter"
                                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400"
                                    >
                                        Terapkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button
                        @click="exportToCSV"
                        class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-white shadow-md transition hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-400"
                    >
                        Export CSV
                    </button>
                    <Link
                        href="/peminjam/create"
                        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-white shadow-md transition hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400"
                    >
                        + Tambah Peminjam
                    </Link>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-md dark:border-slate-700 dark:bg-slate-800">
                <table class="min-w-full table-auto text-sm text-gray-700 dark:text-gray-200">
                    <thead class="bg-blue-100 text-blue-700 uppercase dark:bg-slate-700 dark:text-blue-300">
                        <tr>
                            <th class="border border-gray-200 px-6 py-3 text-center dark:border-slate-700">No</th>
                            <th class="border border-gray-200 px-6 py-3 text-center dark:border-slate-700">Nama Peminjam</th>
                            <th class="border border-gray-200 px-6 py-3 text-center dark:border-slate-700">Kelas</th>
                            <th class="border border-gray-200 px-6 py-3 text-center dark:border-slate-700">Tanggal Peminjaman</th>
                            <th class="border border-gray-200 px-6 py-3 text-center dark:border-slate-700">Nama Barang</th>
                            <th class="border border-gray-200 px-6 py-3 text-center dark:border-slate-700">Jumlah</th>
                            <th class="border border-gray-200 px-6 py-3 text-center dark:border-slate-700">Keterangan</th>
                            <th class="border border-gray-200 px-6 py-3 text-center dark:border-slate-700">Status</th>
                            <th class="border border-gray-200 px-6 py-3 text-center dark:border-slate-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(peminjam, index) in filteredPeminjam"
                            :key="peminjam.id"
                            class="transition hover:bg-blue-50 dark:hover:bg-slate-700"
                        >
                            <td class="border border-gray-200 px-6 py-4 text-center align-middle dark:border-slate-700">{{ index + 1 }}</td>
                            <td class="border border-gray-200 px-6 py-4 text-center align-middle dark:border-slate-700">{{ peminjam.nama_siswa }}</td>
                            <td class="border border-gray-200 px-6 py-4 text-center align-middle dark:border-slate-700">{{ peminjam.kelas }}</td>
                            <td class="border border-gray-200 px-6 py-4 text-center align-middle dark:border-slate-700">
                                {{ peminjam.tanggal_peminjaman }}
                            </td>
                            <td class="border border-gray-200 px-6 py-4 text-center align-middle dark:border-slate-700">
                                {{ peminjam.nama_barang }}
                            </td>
                            <td class="border border-gray-200 px-6 py-4 text-center align-middle dark:border-slate-700">
                                {{ peminjam.jumlah_barang }}
                            </td>
                            <td class="border border-gray-200 px-6 py-4 text-center align-middle dark:border-slate-700">{{ peminjam.keterangan }}</td>
                            <td class="border border-gray-200 px-6 py-4 text-center align-middle dark:border-slate-700">
                                <select
                                    :value="peminjam.status"
                                    @change="updateStatus(peminjam.id, ($event.target as HTMLSelectElement).value)"
                                    class="rounded-lg border border-gray-300 px-3 py-1 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white"
                                >
                                    <option
                                        v-for="option in statusOptions"
                                        :key="option.value"
                                        :value="option.value"
                                        :selected="peminjam.status === option.value"
                                    >
                                        {{ option.label }}
                                    </option>
                                </select>
                            </td>
                            <td class="border border-gray-200 px-6 py-4 text-center align-middle dark:border-slate-700">
                                <div class="flex items-center justify-center gap-2">
                                    <Link
                                        :href="`/peminjam/${peminjam.id}/edit`"
                                        class="inline-flex items-center gap-1 rounded bg-yellow-500 px-3 py-1 text-white shadow transition hover:bg-yellow-600 dark:bg-yellow-400 dark:hover:bg-yellow-500"
                                    >
                                        <Pencil class="h-4 w-4" /> Edit
                                    </Link>
                                    <button
                                        @click="deleteItem(peminjam.id)"
                                        class="inline-flex items-center gap-1 rounded bg-red-600 px-3 py-1 text-white shadow transition hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600"
                                    >
                                        <Trash2 class="h-4 w-4" /> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="filteredPeminjam.length === 0">
                            <td colspan="9" class="py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada data ditemukan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
