<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Data peminjam',
        href: '/peminjam',
    },
];

defineProps({
    peminjam: {
        type: Array,
        required: true,
    },
});

const form = useForm();

function deleteItem(id){
    if (confirm("Apakah anda yakin akan menghapus ini?")) {
        form.delete(route('peminjam.destroy', id), {
            preserveScroll: true
        })
    }
}

</script>

<template>
    <Head title="Data" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Link href="/peminjam/create">Create</Link>
            <table>
                <thead>
                    <td>Nama peminjam</td>
                    <td>Kelas</td>
                    <td>Nama Barang</td>
                    <td>Jumlah</td>
                    <td>keterangan</td>
                    <td>Aksi</td>
                </thead>
                <tbody v-for="peminjam in peminjam" :key="peminjam.id">
                    <td>{{ peminjam.nama_siswa }}</td>
                    <td>{{ peminjam.kelas }}</td>
                    <td>{{ peminjam.nama_barang }}</td>
                    <td>{{ peminjam.jumlah_barang }}</td>
                    <td>{{ peminjam.keterangan }}</td>
                    <td>
                        <Link :href="`/peminjam/${peminjam.id}/edit`">Edit</Link>
                        <button @click="deleteItem(peminjam.id)">Delete</button>
                    </td>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
