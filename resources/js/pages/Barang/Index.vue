<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Link, router, useForm, usePage } from '@inertiajs/vue3';
import { Pencil, Trash2 } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Data Barang', href: '/barang' }];

interface FlashProps {
    success?: string;
}

interface PageProps {
    errors?: Record<string, string>;
    flash?: FlashProps;
    [key: string]: unknown;
}

const page = usePage<PageProps>();

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
const fileInput = ref<HTMLInputElement | null>(null);
const showFileError = ref(false);

const filteredBarang = computed(() => {
    const keyword = search.value.toLowerCase();
    return props.data_barang.filter((barang) => barang.nama_barang.toLowerCase().includes(keyword));
});

function deleteItem(id: number) {
    if (confirm('Apakah anda yakin akan menghapus ini?')) {
        form.delete(route('barang.destroy', id), {
            preserveScroll: true,
        });
    }
}

function triggerFileInput() {
    fileInput.value?.click();
}

function handleFileChange(event: Event) {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('file', file);

    router.post('/barang/import', formData, {
        onSuccess: () => {
            alert('Impor berhasil!');
        },
        onError: () => {
            showFileError.value = true;
            setTimeout(() => {
                showFileError.value = false;
            }, 2000);
        },
        forceFormData: true,
    });

    target.value = '';
}

watch(
    () => page.props.errors?.file,
    (newVal) => {
        if (newVal) {
            showFileError.value = true;
            setTimeout(() => {
                showFileError.value = false;
            }, 2000);
        }
    },
);
</script>

<template>
    <!-- Notifikasi flash sukses -->
    <div
        v-if="page.props.flash?.success"
        class="mb-4 rounded border border-green-300 bg-green-100 px-4 py-2 text-green-800 dark:bg-green-900 dark:text-green-200"
    >
        {{ page.props.flash.success }}
    </div>

    <!-- Notifikasi error file (otomatis hilang) -->
    <transition name="fade">
        <div v-if="showFileError" class="fixed top-6 right-6 z-50 rounded-lg bg-red-600 px-4 py-2 text-sm text-white shadow-md dark:bg-red-500">
            Format file tidak valid. Harus CSV.
        </div>
    </transition>

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex min-h-screen flex-col gap-6 rounded-xl bg-gradient-to-br from-blue-50 via-white to-blue-100 p-6 font-[Poppins] shadow-lg dark:from-slate-800 dark:via-slate-900 dark:to-slate-800"
        >
            <!-- Header -->
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h1 class="text-2xl font-semibold text-blue-800 dark:text-white">Data Barang</h1>
                <div class="flex flex-col items-start gap-2 sm:flex-row sm:items-center">
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Cari nama barang..."
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:placeholder-gray-400"
                    />
                    <Link
                        href="/barang/create"
                        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-white shadow-md transition hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400"
                    >
                        + Tambah Barang
                    </Link>
                    <button
                        type="button"
                        @click="triggerFileInput"
                        class="rounded-lg bg-green-600 px-4 py-2 text-white shadow hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-400"
                    >
                        Impor CSV
                    </button>
                    <input ref="fileInput" type="file" accept=".csv" class="hidden" @change="handleFileChange" />
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-md dark:border-slate-700 dark:bg-slate-800">
                <table class="min-w-full table-auto text-sm text-gray-700 dark:text-gray-200">
                    <thead class="bg-blue-100 text-blue-700 uppercase dark:bg-slate-700 dark:text-blue-300">
                        <tr>
                            <th class="border px-6 py-3 text-center dark:border-slate-700">No</th>
                            <th class="border px-6 py-3 text-center dark:border-slate-700">Nama Barang</th>
                            <th class="border px-6 py-3 text-center dark:border-slate-700">Jumlah</th>
                            <th class="border px-6 py-3 text-center dark:border-slate-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(barang, index) in filteredBarang" :key="barang.id" class="transition hover:bg-blue-50 dark:hover:bg-slate-700">
                            <td class="border px-6 py-4 text-center align-middle dark:border-slate-700">{{ index + 1 }}</td>
                            <td class="border px-6 py-4 text-center align-middle dark:border-slate-700">{{ barang.nama_barang }}</td>
                            <td class="border px-6 py-4 text-center align-middle dark:border-slate-700">
                                {{ barang.jumlah_barang }}
                            </td>
                            <td class="border px-6 py-4 text-center align-middle dark:border-slate-700">
                                <div class="flex items-center justify-center gap-2">
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
                            <td colspan="4" class="py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada data ditemukan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
