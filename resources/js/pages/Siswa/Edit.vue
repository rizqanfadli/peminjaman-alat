<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';

interface Siswa {
    id: number;
    nis: string | number;
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
    nis: props.siswa.nis,
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
        <div class="dark:bg-muted flex flex-col gap-6 rounded-xl bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold tracking-tight">Form Edit Siswa</h2>
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
                    <Button type="submit" class="w-full">Simpan Perubahan</Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
