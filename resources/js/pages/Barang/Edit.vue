<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button'; // Tambahkan import Button

interface Barang {
    id: number;
    nama_barang: string;
    gambar_barang: string;
    jumlah_barang: number;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edit Barang',
        href: '/barang',
    },
];

const props = defineProps<{
    data_barang: Barang
}>();

const form = useForm({
    nama_barang: props.data_barang.nama_barang,
    gambar_barang: props.data_barang.gambar_barang,
    jumlah_barang: props.data_barang.jumlah_barang,
});

function submit() {
    form.put(route('barang.update', props.data_barang.id), {
        preserveScroll: true,
        // Jangan reset form setelah update, biasanya untuk edit
        // onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <Head title="Edit Barang" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div>
                <Link href="/barang">Back</Link>
            </div>
            <form @submit.prevent="submit">
                <div class="grid gap-2">
                    <Label for="nama_barang">Nama Barang</Label>
                    <Input
                        id="nama_barang"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.nama_barang"
                        placeholder="Nama Barang"
                    />
                    <InputError class="mt-2" :message="form.errors.nama_barang" />
                </div>
                <div class="grid gap-2">
                    <Label for="jumlah_barang">Jumlah Barang:</Label>
                    <Input
                        id="jumlah_barang"
                        type="number"
                        class="mt-1 block w-full"
                        v-model="form.jumlah_barang"
                        placeholder="Kelas"
                    />
                    <InputError class="mt-2" :message="form.errors.jumlah_barang" />
                </div>
                <div class="flex items-center gap-4">
                    <Button type="submit">Submit</Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
