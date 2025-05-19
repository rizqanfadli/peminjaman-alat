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
        title: 'Tambah Barang',
        href: '/barang/create',
    },
];

defineProps({
    data_barang: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    nama_barang: '',
    jumlah_barang: '',
});

function submit() {
    form.post(route('barang.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <Head title="Tambah Barang" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="mx-auto w-full max-w-4xl rounded-xl border border-blue-200 bg-gradient-to-b from-blue-50 via-white to-white p-8 shadow-md transition dark:border-gray-700 dark:from-gray-900 dark:via-gray-950 dark:to-gray-900 dark:text-gray-100"
        >
            <div class="mb-6 flex items-center gap-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                <ArrowLeft class="h-5 w-5" />
                <Link href="/barang" class="font-semibold">Kembali</Link>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <Label for="nama_barang" class="font-semibold text-blue-700 dark:text-blue-300">Nama Barang</Label>
                    <Input
                        id="nama_barang"
                        type="text"
                        class="mt-1 block w-full rounded-md border border-blue-300 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-blue-500"
                        v-model="form.nama_barang"
                        placeholder="Masukkan nama barang"
                    />
                    <InputError class="mt-2 text-red-600 dark:text-red-400" :message="form.errors.nama_barang" />
                </div>

                <div>
                    <Label for="jumlah_barang" class="font-semibold text-blue-700 dark:text-blue-300">Jumlah</Label>
                    <Input
                        id="jumlah_barang"
                        type="number"
                        class="mt-1 block w-full rounded-md border border-blue-300 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-blue-500"
                        v-model="form.jumlah_barang"
                        placeholder="Masukkan jumlah barang"
                    />
                    <InputError class="mt-2 text-red-600 dark:text-red-400" :message="form.errors.jumlah_barang" />
                </div>

                <div class="flex justify-end">
                    <Button
                        type="submit"
                        class="flex items-center gap-2 rounded-lg bg-blue-600 px-6 py-2 font-semibold text-white shadow-md transition hover:bg-blue-700 active:scale-95 dark:bg-blue-500 dark:hover:bg-blue-400"
                        :disabled="form.processing"
                    >
                        <PlusCircle class="h-5 w-5" />
                        Submit
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
