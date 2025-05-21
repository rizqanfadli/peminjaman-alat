<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Pencil, Trash2 } from 'lucide-vue-next';
import { ref, computed } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Data Barang', href: '/barang' },
];

interface Barang {
    id: number;
    nama_barang: string;
    jumlah_barang: number;
}

const props = defineProps<{
    data_barang: Barang[];
}>();

const form = useForm({});
const search = ref('');

const filteredBarang = computed(() => {
    const keyword = search.value.toLowerCase();
    return props.data_barang.filter((barang) =>
        barang.nama_barang.toLowerCase().includes(keyword)
    );
});

function deleteItem(id: number) {
    if (confirm('Apakah anda yakin akan menghapus ini?')) {
        form.delete(route('barang.destroy', id), {
            preserveScroll: true,
        });
    }
}
</script>

<template>
    <Head title="Data Barang" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex min-h-screen flex-col gap-6 rounded-xl bg-gradient-to-br from-blue-50 via-white to-blue-100 p-6 shadow-lg dark:from-slate-800 dark:via-slate-900 dark:to-slate-800 font-[Poppins]">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <h1 class="text-2xl font-semibold text-blue-800 dark:text-white">Data Barang</h1>
                <div class="flex flex-col sm:flex-row gap-2 items-start sm:items-center">
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Cari nama barang..."
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-slate-700 dark:text-white dark:border-slate-600 dark:placeholder-gray-400"
                    />
                    <Link
                        href="/barang/create"
                        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-white shadow-md transition hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400"
                    >
                        + Tambah Barang
                    </Link>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto rounded-xl bg-white shadow-md dark:bg-slate-800 border border-gray-200 dark:border-slate-700">
                <table class="min-w-full table-auto text-sm text-gray-700 dark:text-gray-200">
                    <thead class="bg-blue-100 text-blue-700 uppercase dark:bg-slate-700 dark:text-blue-300">
                        <tr>
                            <th class="border border-gray-200 dark:border-slate-700 px-6 py-3 text-center">No</th>
                            <th class="border border-gray-200 dark:border-slate-700 px-6 py-3 text-center">Nama Barang</th>
                            <th class="border border-gray-200 dark:border-slate-700 px-6 py-3 text-center">Jumlah</th>
                            <th class="border border-gray-200 dark:border-slate-700 px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(barang, index) in filteredBarang"
                            :key="barang.id"
                            class="transition hover:bg-blue-50 dark:hover:bg-slate-700"
                        >
                            <td class="border border-gray-200 dark:border-slate-700 px-6 py-4 text-center align-middle">{{ index + 1 }}</td>
                            <td class="border border-gray-200 dark:border-slate-700 px-6 py-4 text-center align-middle">{{ barang.nama_barang }}</td>
                            <td class="border border-gray-200 dark:border-slate-700 px-6 py-4 text-center align-middle">{{ barang.jumlah_barang }}</td>
                            <td class="border border-gray-200 dark:border-slate-700 px-6 py-4 text-center align-middle">
                                <div class="flex justify-center items-center gap-2">
                                    <Link
                                        :href="`/barang/${barang.id}/edit`"
                                        class="inline-flex items-center gap-1 rounded bg-yellow-500 px-3 py-1 text-white shadow transition hover:bg-yellow-600 dark:bg-yellow-400 dark:hover:bg-yellow-500"
                                    >
                                        <Pencil class="h-4 w-4" /> Edit
                                    </Link>
                                    <button
                                        @click="deleteItem(barang.id)"
                                        class="inline-flex items-center gap-1 rounded bg-red-600 px-3 py-1 text-white shadow transition hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600"
                                    >
                                        <Trash2 class="h-4 w-4" /> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="filteredBarang.length === 0">
                            <td colspan="4" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                Tidak ada data ditemukan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
