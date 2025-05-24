<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, Save } from 'lucide-vue-next';

interface Siswa {
    id: number;
    nama: string;
    kelas: string;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edit Siswa',
        href: '/siswa',
    },
];

const props = defineProps<{
    siswa: Siswa;
}>();

const form = useForm({
    nama: props.siswa.nama,
    kelas: props.siswa.kelas,
});

function submit() {
    form.put(route('siswa.update', props.siswa.id), {
        preserveScroll: true,
    });
}
</script>

<template>
    <Head title="Edit Siswa" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex min-h-screen flex-col gap-6 rounded-xl bg-gradient-to-br from-blue-50 via-white to-blue-100 p-6 font-[Poppins] shadow-lg dark:from-slate-800 dark:via-slate-900 dark:to-slate-800 dark:text-gray-100"
        >
            <!-- Judul seperti di kode daftar siswa -->
            <h1 class="text-2xl font-semibold text-blue-800 dark:text-white">Edit Data Siswa</h1>

            <div
                class="mx-auto w-full max-w-4xl rounded-xl border border-gray-200 bg-white p-8 shadow-md transition dark:border-slate-700 dark:bg-slate-800"
            >
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Nama -->
                    <div>
                        <Label for="nama" class="block text-sm font-medium text-blue-700 dark:text-blue-400">Nama Siswa</Label>
                        <Input
                            id="nama"
                            type="text"
                            class="mt-1 block w-full rounded-md border border-blue-300 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                            v-model="form.nama"
                            placeholder="Masukkan Nama"
                        />
                        <InputError class="mt-2 text-red-600 dark:text-red-400" :message="form.errors.nama" />
                    </div>

                    <!-- Kelas -->
                    <div>
                        <Label for="kelas" class="block text-sm font-medium text-blue-700 dark:text-blue-400">Kelas</Label>
                        <Input
                            id="kelas"
                            type="text"
                            class="mt-1 block w-full rounded-md border border-blue-300 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                            v-model="form.kelas"
                            placeholder="Contoh: XII TJKT 2"
                        />
                        <InputError class="mt-2 text-red-600 dark:text-red-400" :message="form.errors.kelas" />
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="mt-8 flex items-center justify-between">
                        <Link
                            href="/siswa"
                            class="flex items-center gap-2 text-blue-600 transition hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
                        >
                            <ArrowLeft class="h-5 w-5" />
                            <span class="font-semibold">Kembali</span>
                        </Link>

                        <Button
                            type="submit"
                            class="flex items-center gap-2 rounded-lg bg-blue-600 px-6 py-2 font-semibold text-white shadow-md transition hover:bg-blue-700 active:scale-95 dark:bg-blue-500 dark:hover:bg-blue-400"
                            :disabled="form.processing"
                        >
                            <Save class="h-5 w-5" />
                            Simpan Perubahan
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
