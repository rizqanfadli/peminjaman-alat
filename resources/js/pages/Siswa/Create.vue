<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, PlusCircle } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tambah Siswa',
        href: '/siswa/create',
    },
];

defineProps({
    data_siswa: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    nama: '',
    kelas: '',
});

function submit() {
    form.post(route('siswa.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <Head title="Tambah Siswa" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="mx-auto w-full max-w-4xl rounded-xl border border-blue-200 bg-gradient-to-b from-blue-50 via-white to-white p-8 shadow-md transition dark:border-gray-700 dark:from-gray-900 dark:via-gray-950 dark:to-gray-900 dark:text-gray-100"
        >
            <form @submit.prevent="submit" class="space-y-6">
                <!-- Nama -->
                <div>
                    <Label for="nama" class="font-semibold text-blue-700 dark:text-blue-300">Nama</Label>
                    <Input
                        id="nama"
                        type="text"
                        class="mt-1 block w-full rounded-md border border-blue-300 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                        v-model="form.nama"
                        placeholder="Masukkan nama siswa"
                    />
                    <InputError class="mt-2 text-red-600 dark:text-red-400" :message="form.errors.nama" />
                </div>

                <!-- Kelas -->
                <div>
                    <Label for="kelas" class="font-semibold text-blue-700 dark:text-blue-300">Kelas</Label>
                    <Input
                        id="kelas"
                        type="text"
                        class="mt-1 block w-full rounded-md border border-blue-300 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                        v-model="form.kelas"
                        placeholder="Contoh: XII TJKT 2"
                    />
                    <InputError class="mt-2 text-red-600 dark:text-red-400" :message="form.errors.kelas" />
                </div>

                <!-- Tombol -->
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
                        <PlusCircle class="h-5 w-5" />
                        Simpan
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
