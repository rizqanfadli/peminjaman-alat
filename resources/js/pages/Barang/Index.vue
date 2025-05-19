<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Pencil, Trash2 } from 'lucide-vue-next'; // Icon edit & hapus

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Data Barang',
        href: '/barang',
    },
];

// Define the type for a single barang item
interface Barang {
    id: number;
    nama_barang: string;
    jumlah_barang: number;
}

defineProps<{
    data_barang: Barang[];
}>();

const form = useForm({});

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
        <div
            class="flex min-h-screen flex-col gap-6 rounded-xl bg-gradient-to-br from-blue-50 via-white to-blue-100 p-6 shadow-lg dark:from-slate-800 dark:via-slate-900 dark:to-slate-800"
        >
            <!-- Header -->
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-blue-800 dark:text-white">Data Barang</h1>
                <Link
                    href="/barang/create"
                    class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-white shadow-md transition hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400"
                >
                    <span class="font-medium">+ Tambah Barang</span>
                </Link>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto rounded-xl bg-white shadow-md dark:bg-slate-800">
                <table class="min-w-full text-left text-sm text-gray-700 dark:text-gray-200">
                    <thead class="bg-blue-100 text-sm text-blue-700 uppercase dark:bg-slate-700 dark:text-blue-300">
                        <tr>
                            <th class="px-6 py-3">No</th>
                            <th class="px-6 py-3">Nama Barang</th>
                            <th class="px-6 py-3">Jumlah</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(barang, index) in data_barang"
                            :key="barang.id"
                            class="border-b transition hover:bg-blue-50 dark:hover:bg-slate-700"
                        >
                            <td class="px-6 py-4">{{ index + 1 }}</td>
                            <td class="px-6 py-4">{{ barang.nama_barang }}</td>
                            <td class="px-6 py-4">{{ barang.jumlah_barang }}</td>
                            <td class="flex gap-2 px-6 py-4">
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
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
