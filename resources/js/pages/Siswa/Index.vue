<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Pencil, Trash2 } from 'lucide-vue-next';
import { ref, computed } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Data Siswa', href: '/siswa' },
];

interface Siswa {
    id: number;
    nama: string;
    kelas: string;
}

const props = defineProps<{
    data_siswa: Siswa[];
}>();

const search = ref('');

const filteredSiswa = computed(() => {
    const keyword = search.value.toLowerCase();
    return props.data_siswa.filter((siswa) =>
        siswa.nama.toLowerCase().includes(keyword) ||
        siswa.kelas.toLowerCase().includes(keyword) 
    );
});

const form = useForm({});

function deleteItem(id: number) {
    if (confirm('Apakah anda yakin akan menghapus ini?')) {
        form.delete(route('siswa.destroy', id), {
            preserveScroll: true,
        });
    }
}
</script>

<template>
    <Head title="Data Siswa" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex min-h-screen flex-col gap-6 rounded-xl bg-gradient-to-br from-blue-50 via-white to-blue-100 p-6 shadow-lg dark:from-slate-800 dark:via-slate-900 dark:to-slate-800 font-[Poppins]">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <h1 class="text-2xl font-semibold text-blue-800 dark:text-white">Data Siswa</h1>
                <div class="flex flex-col sm:flex-row gap-2 items-start sm:items-center">
                    <!-- Pastikan ada v-model di sini -->
                    <input
                        v-model="search"
                        type="search"
                        placeholder="Cari nama/kelas..."
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-slate-700 dark:text-white dark:border-slate-600 dark:placeholder-gray-400"
                    />
                    <Link
                        href="/siswa/create"
                        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-white shadow-md transition hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400"
                    >
                        + Tambah Siswa
                    </Link>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto rounded-xl bg-white shadow-md dark:bg-slate-800 border border-gray-200 dark:border-slate-700">
                <table class="min-w-full table-auto text-sm text-gray-700 dark:text-gray-200">
                    <thead class="bg-blue-100 text-blue-700 uppercase dark:bg-slate-700 dark:text-blue-300">
                        <tr>
                            <th class="border border-gray-200 dark:border-slate-700 px-6 py-3 text-center">No</th>
                            <th class="border border-gray-200 dark:border-slate-700 px-6 py-3 text-center">Nama Siswa</th>
                            <th class="border border-gray-200 dark:border-slate-700 px-6 py-3 text-center">Kelas</th>
                            <th class="border border-gray-200 dark:border-slate-700 px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Pakai filteredSiswa di v-for -->
                        <tr
                            v-for="(siswa, index) in filteredSiswa"
                            :key="siswa.id"
                            class="transition hover:bg-blue-50 dark:hover:bg-slate-700"
                        >
                            <td class="border border-gray-200 dark:border-slate-700 px-6 py-4 text-center align-middle">{{ index + 1 }}</td>
                            <td class="border border-gray-200 dark:border-slate-700 px-6 py-4 text-center align-middle">{{ siswa.nama }}</td>
                            <td class="border border-gray-200 dark:border-slate-700 px-6 py-4 text-center align-middle">{{ siswa.kelas }}</td>
                            <td class="border border-gray-200 dark:border-slate-700 px-6 py-4 text-center align-middle">
                                <div class="flex justify-center items-center gap-2">
                                    <Link
                                        :href="`/siswa/${siswa.id}/edit`"
                                        class="inline-flex items-center gap-1 rounded bg-yellow-500 px-3 py-1 text-white shadow transition hover:bg-yellow-600 dark:bg-yellow-400 dark:hover:bg-yellow-500"
                                    >
                                        <Pencil class="h-4 w-4" /> Edit
                                    </Link>
                                    <button
                                        @click="deleteItem(siswa.id)"
                                        class="inline-flex items-center gap-1 rounded bg-red-600 px-3 py-1 text-white shadow transition hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600"
                                    >
                                        <Trash2 class="h-4 w-4" /> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="filteredSiswa.length === 0">
                            <td colspan="5" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                Tidak ada data ditemukan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
