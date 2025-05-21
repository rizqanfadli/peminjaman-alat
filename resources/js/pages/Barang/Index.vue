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

const form = useForm();

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
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Link href="/barang/create">Create</Link>
            <table>
                <thead>
                    <td>Nama Barang</td>
                    <td>Jumlah</td>
                    <td>Aksi</td>
                </thead>
                <tbody v-for="data_barang in data_barang" :key="data_barang.id">
                    <td>{{ data_barang.nama_barang }}</td>
                    <td>{{ data_barang.jumlah_barang }}</td>
                    <td>
                        <Link :href="`/barang/${data_barang.id}/edit`">Edit</Link>
                        <button @click="deleteItem(data_barang.id)">Delete</button>
                    </td>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
