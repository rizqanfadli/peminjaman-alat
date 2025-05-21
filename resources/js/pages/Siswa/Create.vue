<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';

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
    nis: '',
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
        <div class="dark:bg-muted flex flex-col gap-6 rounded-xl bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold tracking-tight">Form Tambah Siswa</h2>
                <Link href="/siswa">
                    <Button variant="outline">← Kembali</Button>
                </Link>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div class="grid gap-2">
                    <Label for="nis">NIS</Label>
                    <Input id="nis" type="number" v-model="form.nis" placeholder="Masukkan NIS" />
                    <InputError class="text-sm text-red-500" :message="form.errors.nis" />
                </div>

                <div class="grid gap-2">
                    <Label for="nama">Nama</Label>
                    <Input id="nama" type="text" v-model="form.nama" placeholder="Masukkan Nama" />
                    <InputError class="text-sm text-red-500" :message="form.errors.nama" />
                </div>

                <div class="grid gap-2">
                    <Label for="kelas">Kelas</Label>
                    <Input id="kelas" type="text" v-model="form.kelas" placeholder="Contoh: XII TJKT 2" />
                    <InputError class="text-sm text-red-500" :message="form.errors.kelas" />
                </div>

                <div class="pt-4">
                    <Button type="submit" class="w-full bg-blue-600 hover:bg-blue-700">Simpan</Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
