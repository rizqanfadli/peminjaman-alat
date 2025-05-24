<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { Pencil, Trash2 } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [{ title: '', href: '/siswa' }];

interface FlashProps {
    success?: string;
}

interface PageProps {
    errors?: Record<string, string>;
    flash?: FlashProps;
    [key: string]: unknown;
}

const page = usePage<PageProps>();

interface Siswa {
    id: number;
    nama: string;
    kelas: string;
}

const props = defineProps<{
    data_siswa: Siswa[];
}>();

const form = useForm({});
const search = ref('');
const fileInput = ref<HTMLInputElement | null>(null);
const showFileError = ref(false);
const selectedItems = ref<number[]>([]); // Array to hold selected item IDs

const filteredSiswa = computed(() => {
    const keyword = search.value.toLowerCase();
    return props.data_siswa.filter((siswa) => siswa.nama.toLowerCase().includes(keyword) || siswa.kelas.toLowerCase().includes(keyword));
});

// Function to check if a siswa is selected
function isSelected(id: number) {
    return selectedItems.value.includes(id);
}

// Function to toggle selection of an item
function toggleSelection(id: number) {
    const index = selectedItems.value.indexOf(id);
    if (index > -1) {
        selectedItems.value.splice(index, 1);
    } else {
        selectedItems.value.push(id);
    }
}

// Function to select all items
function toggleSelectAll(event: Event) {
    const target = event.target as HTMLInputElement;
    if (target.checked) {
        selectedItems.value = filteredSiswa.value.map((siswa) => siswa.id);
    } else {
        selectedItems.value = [];
    }
}

function deleteSelectedItems(items: number[]) {
    if (items.length === 0) return;

    if (confirm('Apakah anda yakin akan menghapus item yang dipilih?')) {
        Promise.all(items.map((id) => form.delete(route('siswa.destroy', id), { preserveScroll: true }))).then(() => {
            selectedItems.value = []; // Clear selected items after deletion
        });
    }
}

// Function to delete a single item
function deleteItem(id: number) {
    if (confirm('Apakah anda yakin akan menghapus siswa ini?')) {
        form.delete(route('siswa.destroy', id), { preserveScroll: true });
    }
}

function triggerFileInput() {
    fileInput.value?.click();
}

function handleFileChange(event: Event) {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];
    if (!file) return;

    // Validate file type
    const validTypes = ['text/csv', 'application/vnd.ms-excel'];
    if (!validTypes.includes(file.type) && !file.name.endsWith('.csv')) {
        showFileError.value = true;
        setTimeout(() => {
            showFileError.value = false;
        }, 2000);
        return;
    }

    const formData = new FormData();
    formData.append('file', file);

    router.post('/siswa/import', formData, {
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
    <Head title="Data Siswa" />

    <!-- Flash success notification -->
    <div
        v-if="page.props.flash?.success"
        class="mb-4 rounded border border-green-300 bg-green-100 px-4 py-2 text-green-800 dark:bg-green-900 dark:text-green-200"
    >
        {{ page.props.flash.success }}
    </div>

    <!-- Error notification for file (auto hide) -->
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
                <h1 class="text-2xl font-semibold text-blue-800 dark:text-white">Data Siswa</h1>
                <div class="flex flex-col items-start gap-2 sm:flex-row sm:items-center">
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Cari nama atau kelas..."
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:placeholder-gray-400"
                    />
                    <Link
                        href="/siswa/create"
                        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-white shadow-md transition hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400"
                    >
                        + Tambah Siswa
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
                            <th class="border px-6 py-3 text-center dark:border-slate-700">
                                <input
                                    type="checkbox"
                                    @change="toggleSelectAll"
                                    :checked="selectedItems.length === filteredSiswa.length && filteredSiswa.length > 0"
                                    :indeterminate="selectedItems.length > 0 && selectedItems.length < filteredSiswa.length"
                                />
                            </th>
                            <th class="border px-6 py-3 text-center dark:border-slate-700">No</th>
                            <th class="border px-6 py-3 text-center dark:border-slate-700">Nama Siswa</th>
                            <th class="border px-6 py-3 text-center dark:border-slate-700">Kelas</th>
                            <th class="border px-6 py-3 text-center dark:border-slate-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(siswa, index) in filteredSiswa" :key="siswa.id" class="transition hover:bg-blue-50 dark:hover:bg-slate-700">
                            <td class="border px-6 py-4 text-center align-middle dark:border-slate-700">
                                <input type="checkbox" :value="siswa.id" :checked="isSelected(siswa.id)" @change="toggleSelection(siswa.id)" />
                            </td>
                            <td class="border px-6 py-4 text-center align-middle dark:border-slate-700">{{ index + 1 }}</td>
                            <td class="border px-6 py-4 text-center align-middle dark:border-slate-700">{{ siswa.nama }}</td>
                            <td class="border px-6 py-4 text-center align-middle dark:border-slate-700">{{ siswa.kelas }}</td>
                            <td class="border px-6 py-4 text-center align-middle dark:border-slate-700">
                                <div v-if="selectedItems.length === 0" class="flex items-center justify-center gap-2">
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

                                <div
                                    v-else-if="selectedItems.length === 1 && selectedItems.includes(siswa.id)"
                                    class="flex items-center justify-center gap-2"
                                >
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

                                <div v-else-if="selectedItems.length > 1 && selectedItems.includes(siswa.id)" class="flex justify-center">
                                    <button
                                        @click.prevent="deleteSelectedItems(selectedItems)"
                                        class="inline-flex items-center gap-1 rounded bg-red-600 px-3 py-1 text-white shadow transition hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600"
                                    >
                                        <Trash2 class="h-4 w-4" /> Hapus Terpilih ({{ selectedItems.length }})
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="filteredSiswa.length === 0">
                            <td colspan="5" class="py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada data ditemukan.</td>
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
