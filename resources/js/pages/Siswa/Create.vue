<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tambah Siswa',
        href: '/siswa/create',
    },
];

const proops = defineProps({
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
    <Head title="Data" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div>
                <Link href="/siswa">Back</Link>
            </div>
            <form @submit.prevent="submit">
                <div class="grid gap-2">
                        <Label for="nis">NIS</Label>
                        <Input
                            id="nis"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.nis"
                            placeholder="NIS"
                        />
                        <InputError class="mt-2" :message="form.errors.nis" />
                     </div>
                <div class="grid gap-2">
                        <Label for="nama">Nama</Label>
                        <Input
                            id="nama"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.nama"
                            placeholder="Nama"
                        />
                        <InputError class="mt-2" :message="form.errors.nama" />
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
                    <div class="flex items-center gap-4">
                       <Button>Submit</Button>
                   </div>

            </form>
        </div>
    </AppLayout>
</template>
