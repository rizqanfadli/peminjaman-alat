<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Data Siswa',
        href: '/siswa',
    },
];

const props = defineProps({
    data_siswa: {
        type: Array,
        required: true,
    },
});

const form = useForm();

function deleteItem(id){
    if (confirm("Apakah anda yakin akan menghapus ini?")) {
        form.delete(route('siswa.destroy', id), {
            preserveScroll: true
        })
    }
}

</script>

<template>
    <Head title="Data" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Link href="/siswa/create">Create</Link>
            <table>
                <thead>
                    <td>NIS</td>
                    <td>Nama Siswa</td>
                    <td>Kelas</td>
                    <td>Aksi</td>
                </thead>
                <tbody v-for="data_siswa in data_siswa" :key="data_siswa.id">
                    <td>{{ data_siswa.nis }}</td>
                    <td>{{ data_siswa.nama }}</td>
                    <td>{{ data_siswa.kelas }}</td>
                    <td>
                        <Link :href="`/siswa/${data_siswa.id}/edit`">Edit</Link>
                        <button @click="deleteItem(data_siswa.id)">Delete</button>
                    </td>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
