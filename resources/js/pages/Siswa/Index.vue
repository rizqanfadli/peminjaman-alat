<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Link, useForm } from '@inertiajs/vue3';

interface Siswa {
    id: number;
    nis: string;
    nama: string;
    kelas: string;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Data Siswa',
        href: '/siswa',
    },
];

defineProps<{
    data_siswa: Siswa[];
}>();

const form = useForm({
    nama: ''  // Add search form
});

function handleSearch() {
    form.get(route('siswa.index'), {
        preserveScroll: true,
        preserveState: true
    });
}

function deleteItem(id: number) {
    if (confirm('Apakah anda yakin akan menghapus ini?')) {
        form.delete(route('siswa.destroy', id), {
            preserveScroll: true,
        });
    }
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex min-h-screen flex-col gap-6 rounded-xl bg-gradient-to-br from-blue-50 via-white to-blue-100 p-6 shadow-lg">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-blue-800">Data Siswa</h1>
                <Link href="/siswa/create" class="inline-block rounded-lg bg-blue-600 px-4 py-2 text-white shadow transition hover:bg-blue-700">
                    + Tambah Siswa
                </Link>
            </div>

            <!-- Search -->
            <div class="w-full">
                <form @submit.prevent="handleSearch" class="flex gap-2">
                    <input 
                        type="search" 
                        v-model="form.nama"
                        placeholder="Cari nama siswa..." 
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none"
                    />
                    <button 
                        type="submit" 
                        class="rounded-lg bg-blue-600 px-4 py-2 text-white shadow transition hover:bg-blue-700"
                    >
                        Cari
                    </button>
                </form>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto rounded-xl bg-white shadow-md">
                <table class="min-w-full text-left text-sm text-gray-700">
                    <thead class="bg-blue-100 text-sm text-blue-700 uppercase">
                        <tr>
                            <th class="px-6 py-3">No</th>
                            <th class="px-6 py-3">NIS</th>
                            <th class="px-6 py-3">Nama Siswa</th>
                            <th class="px-6 py-3">Kelas</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="siswa in data_siswa" :key="siswa.id" class="border-b transition hover:bg-blue-50">
                            <td class="px-6 py-4">{{ siswa.id }}</td>
                            <td class="px-6 py-4">{{ siswa.nis }}</td>
                            <td class="px-6 py-4">{{ siswa.nama }}</td>
                            <td class="px-6 py-4">{{ siswa.kelas }}</td>
                            <td class="space-x-2 px-6 py-4">
                                <Link :href="`/siswa/${siswa.id}/edit`" class="text-blue-600 hover:underline"> Edit </Link>
                                <button @click="deleteItem(siswa.id)" class="text-red-600 hover:underline">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
