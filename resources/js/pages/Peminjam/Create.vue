<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button'; // Tambahkan import Button

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tambah peminjam',
        href: '/peminjam/create',
    },
];

const form = useForm({
    nama_siswa: '',
    kelas: '',
    nama_barang: '',
    jumlah_barang: '', // Sesuaikan dengan nama field di controller
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
    <Head title="Data" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div>
                <Link href="/peminjam">Back</Link>
            </div>
            <form @submit.prevent="submit">
                <div class="grid gap-2">
                        <Label for="nama_siswa">Nama peminjam</Label>
                        <Input
                            id="nama_siswa"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.nama_siswa"
                            placeholder="nama siswa"
                        />
                        <InputError class="mt-2" :message="form.errors.nama_siswa" />
                     </div>
                <div class="grid gap-2">
                        <Label for="nama_barang">Nama Barang</Label>
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
                        <Label for="kelas">Kelas</Label>
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
                       <Label for="jumlah_barang">Jumlah:</Label>
                       <Input
                           id="jumlah_barang"
                           type="number"
                           class="mt-1 block w-full"
                           v-model="form.jumlah_barang"
                           placeholder="jumlah"
                       />
                       <InputError class="mt-2" :message="form.errors.jumlah_barang" />
                    </div>
                <div class="grid gap-2">
                       <Label for="keterangan">keterangan:</Label>
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
