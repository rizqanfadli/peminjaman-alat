<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tambah Barang',
        href: '/barang/create',
    },
];

const proops = defineProps({
    data_siswa: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    nama: '',
    gambar: '',
    jumlah: '',
});

function submit() {
    form.post(route('barang.store'), {
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
                <Link href="/barang">Back</Link>
            </div>
            <form @submit.prevent="submit">
                <div class="grid gap-2">
                        <Label for="nis">Nama Barang</Label>
                        <Input
                            id="nama_barang"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.nis"
                            placeholder="Nama Barang"
                        />
                        <InputError class="mt-2" :message="form.errors.nama_barang" />
                     </div>
                <div class="grid gap-2">
                        <Label for="gambar">Gambar</Label>
                        <Input
                            id="nama"
                            type="file"
                            class="mt-1 block w-full"
                            v-model="form.gambar"
                            placeholder="Nama"
                        />
                        <InputError class="mt-2" :message="form.errors.gambar" />
                     </div>
                <div class="grid gap-2">
                       <Label for="jumlah">Jumlah:</Label>
                       <Input
                           id="kelas"
                           type="number"
                           class="mt-1 block w-full"
                           v-model="form.jumlah"
                           placeholder="jumlah"
                       />
                       <InputError class="mt-2" :message="form.errors.jumlah" />
                    </div>
                    <div class="flex items-center gap-4">
                       <Button>Submit</Button>
                   </div>

            </form>
        </div>
    </AppLayout>
</template>
