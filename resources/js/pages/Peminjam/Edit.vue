<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button'; // Tambahkan import Button

interface Peminjam {
    id: number;
    nis: string | number;
    nama: string;
    kelas: string;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edit peminjam',
        href: '/peminjam',
    },
];

const props = defineProps<{
    peminjam: peminjam
}>();

const form = useForm({
    nama_siswa: props.peminjam.nama_siswa,
    kelas: props.peminjam.kelas,
    nama_barang: props.peminjam.nama_barang,
    jumlah_barang: props.peminjam.jumlah_barang,
    keterangan: props.peminjam.keterangan,
});

function submit() {
    form.put(route('peminjam.update', props.peminjam.id), {
        preserveScroll: true,
        // Jangan reset form setelah update, biasanya untuk edit
        // onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <Head title="Edit peminjam" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div>
                <Link href="/peminjam">Back</Link>
            </div>
            <form @submit.prevent="submit">
                <div class="grid gap-2">
                    <Label for="nama_siswa">Nama Siswa</Label>
                    <Input
                        id="nama_siswa"
                        type="number"
                        class="mt-1 block w-full"
                        v-model="form.nama_siswa"
                        placeholder="nama_siswa"
                    />
                    <InputError class="mt-2" :message="form.errors.nama_siswa" />
                </div>
                <div class="grid gap-2">
                    <Label for="kelas">Kelas:</Label>
                    <Input
                        id="kelas"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.kelas"
                        placeholder="Kelas"
                    />
                    <InputError class="mt-2" :message="form.errors.kelas" />
                </div>
                <div class="grid gap-2">
                    <Label for="nama_barang">nama_barang:</Label>
                    <Input
                        id="nama_barang"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.nama_barang"
                        placeholder="nama_barang"
                    />
                    <InputError class="mt-2" :message="form.errors.nama_barang" />
                </div>
                <div class="grid gap-2">
                    <Label for="jumlah_barang">jumlah barang:</Label>
                    <Input
                        id="jumlah_barang"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.jumlah_barang"
                        placeholder="jumlah_barang"
                    />
                    <InputError class="mt-2" :message="form.errors.jumlah_barang" />
                </div>
                <div class="grid gap-2">
                    <Label for="keterangan">keterangan</Label>
                    <Input
                        id="keterangan"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.keterangan"
                        placeholder="keterangan"
                    />
                    <InputError class="mt-2" :message="form.errors.keterangan" />
                </div>
                <div class="flex items-center gap-4">
                    <Button type="submit">Submit</Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
