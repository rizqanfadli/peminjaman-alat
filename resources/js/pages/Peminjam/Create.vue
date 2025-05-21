<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { ArrowLeft, PlusCircle } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tambah Peminjam',
        href: '/peminjam/create',
    },
];

const form = useForm({
    nama_siswa: '',
    kelas: '',
    nama_barang: '',
    jumlah_barang: '',
    keterangan: '',
});

function submit() {
    form.post(route('peminjam.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <Head title="Tambah Peminjam" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="mx-auto w-full max-w-4xl rounded-xl border border-blue-200 bg-gradient-to-b from-blue-50 via-white to-white p-8 shadow-md transition dark:border-gray-700 dark:from-gray-900 dark:via-gray-950 dark:to-gray-900 dark:text-gray-100"
        >
            <form @submit.prevent="submit" class="space-y-6">
                <!-- Nama Siswa -->
                <div>
                    <Label for="nama_siswa" class="font-semibold text-blue-700 dark:text-blue-300">Nama Peminjam</Label>
                    <Input
                        id="nama_siswa"
                        type="text"
                        class="mt-1 block w-full rounded-md border border-blue-300 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                        v-model="form.nama_siswa"
                        placeholder="Masukkan nama siswa"
                    />
                    <InputError class="mt-2 text-red-600 dark:text-red-400" :message="form.errors.nama_siswa" />
                </div>

                <!-- Nama Barang -->
                <div>
                    <Label for="nama_barang" class="font-semibold text-blue-700 dark:text-blue-300">Nama Barang</Label>
                    <Input
                        id="nama_barang"
                        type="text"
                        class="mt-1 block w-full rounded-md border border-blue-300 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                        v-model="form.nama_barang"
                        placeholder="Masukkan nama barang"
                    />
                    <InputError class="mt-2 text-red-600 dark:text-red-400" :message="form.errors.nama_barang" />
                </div>

                <!-- Kelas -->
                <div>
                    <Label for="kelas" class="font-semibold text-blue-700 dark:text-blue-300">Kelas</Label>
                    <Input
                        id="kelas"
                        type="text"
                        class="mt-1 block w-full rounded-md border border-blue-300 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                        v-model="form.kelas"
                        placeholder="Masukkan kelas"
                    />
                    <InputError class="mt-2 text-red-600 dark:text-red-400" :message="form.errors.kelas" />
                </div>

                <!-- Jumlah Barang -->
                <div>
                    <Label for="jumlah_barang" class="font-semibold text-blue-700 dark:text-blue-300">Jumlah</Label>
                    <Input
                        id="jumlah_barang"
                        type="number"
                        class="mt-1 block w-full appearance-none rounded-md border border-blue-300 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                        v-model="form.jumlah_barang"
                        placeholder="Masukkan jumlah"
                    />
                    <InputError class="mt-2 text-red-600 dark:text-red-400" :message="form.errors.jumlah_barang" />
                </div>

                <!-- Keterangan -->
                <div>
                    <Label for="keterangan" class="font-semibold text-blue-700 dark:text-blue-300">Keterangan</Label>
                    <Input
                        id="keterangan"
                        type="text"
                        class="mt-1 block w-full rounded-md border border-blue-300 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                        v-model="form.keterangan"
                        placeholder="Masukkan keterangan"
                    />
                    <InputError class="mt-2 text-red-600 dark:text-red-400" :message="form.errors.keterangan" />
                </div>

                <!-- Tombol -->
                <div class="mt-8 flex items-center justify-between">
                    <Link
                        href="/peminjam"
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
