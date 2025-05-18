<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';

const form = useForm({
    nama_siswa: '',
    kelas: '',
    nama_barang: '',
    jumlah_barang: '',
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
    <Head title="Peminjaman Alat TJKT" />

    <div class="min-h-screen bg-white">
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 py-12">
            <div class="container mx-auto px-6 text-center">
                <img 
                    src="storage/Logo/TKJ.png" 
                    alt="TJKT Logo" 
                    class="h-20 w-auto mx-auto mb-6"
                >
                <h1 class="text-2xl font-bold text-blue-700 mb-4">SMK N 2 Pengasih</h1>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Sistem peminjaman alat yang mudah dan efisien untuk siswa TJKT
                </p>
            </div>
        </div>

        <!-- Main Content -->
        <main class="container mx-auto px-6 py-12 -mt-10">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-blue-100">
                    <div class="bg-blue-600 px-8 py-5">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Form Peminjaman Alat
                        </h2>
                    </div>

                    <div class="p-8 bg-gradient-to-b from-white to-blue-50">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div class="transition-all duration-200 hover:shadow-md p-4 rounded-lg bg-white">
                                <Label for="nama_siswa" class="text-gray-700 font-medium block mb-2">Nama Peminjam</Label>
                                <Input
                                    id="nama_siswa"
                                    type="text"
                                    class="mt-1 block w-full rounded-lg border-blue-200 focus:border-blue-400 focus:ring focus:ring-blue-100"
                                    v-model="form.nama_siswa"
                                    placeholder="Masukkan nama lengkap"
                                />
                                <InputError class="mt-1" :message="form.errors.nama_siswa" />
                            </div>

                            <div class="transition-all duration-200 hover:shadow-md p-4 rounded-lg bg-white">
                                <Label for="kelas" class="text-gray-700 font-medium block mb-2">Kelas *jika hanya satu kelas, pilih yang kecil</Label>
                                <select
                                    id="kelas"
                                    v-model="form.kelas"
                                    class="mt-1 block w-full rounded-lg border-blue-200 focus:border-blue-400 focus:ring focus:ring-blue-100"
                                >
                                    <option value="">Pilih Kelas</option>
                                    <option value="X TJKT 1">X TJKT 1</option>
                                    <option value="X TJKT 2">X TJKT 2</option>
                                    <option value="XI TJKT 1">XI TJKT 1</option>
                                    <option value="XI TJKT 2">XI TJKT 2</option>
                                    <option value="XII TJKT 1">XII TJKT 1</option>
                                    <option value="XII TJKT 2">XII TJKT 2</option>
                                </select>
                                <InputError class="mt-1" :message="form.errors.kelas" />
                            </div>

                            <div class="transition-all duration-200 hover:shadow-md p-4 rounded-lg bg-white">
                                <Label for="nama_barang" class="text-gray-700 font-medium block mb-2">Nama Barang</Label>
                                <Input
                                    id="nama_barang"
                                    type="text"
                                    class="mt-1 block w-full rounded-lg border-blue-200 focus:border-blue-400 focus:ring focus:ring-blue-100"
                                    v-model="form.nama_barang"
                                    placeholder="Nama barang yang dipinjam"
                                />
                                <InputError class="mt-1" :message="form.errors.nama_barang" />
                            </div>

                            <div class="transition-all duration-200 hover:shadow-md p-4 rounded-lg bg-white">
                                <Label for="jumlah_barang" class="text-gray-700 font-medium block mb-2">Jumlah</Label>
                                <Input
                                    id="jumlah_barang"
                                    type="number"
                                    class="mt-1 block w-full rounded-lg border-blue-200 focus:border-blue-400 focus:ring focus:ring-blue-100"
                                    v-model="form.jumlah_barang"
                                    min="1"
                                    placeholder="Jumlah yang dipinjam"
                                />
                                <InputError class="mt-1" :message="form.errors.jumlah_barang" />
                            </div>

                            <div class="transition-all duration-200 hover:shadow-md p-4 rounded-lg bg-white">
                                <Label for="keterangan" class="text-gray-700 font-medium block mb-2">Keterangan (Opsional)</Label>
                                <textarea
                                    id="keterangan"
                                    v-model="form.keterangan"
                                    rows="3"
                                    class="mt-1 block w-full rounded-lg border-blue-200 focus:border-blue-400 focus:ring focus:ring-blue-100"
                                    placeholder="Tambahkan keterangan peminjaman"
                                ></textarea>
                                <InputError class="mt-1" :message="form.errors.keterangan" />
                            </div>

                            <div class="flex justify-end pt-4">
                                <Button
                                    type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg transition-all duration-200 transform hover:scale-105 focus:ring-4 focus:ring-blue-200"
                                >
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Ajukan Peminjaman
                                    </span>
                                </Button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <footer class="bg-gray-50 border-t border-gray-100 mt-12">
            <div class="container mx-auto px-6 py-4">
                <p class="text-center text-gray-500">
                    © {{ new Date().getFullYear() }} Sistem Peminjaman Alat TJKT. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</template>

<style scoped>
.bg-gradient-to-r {
    background-size: 200% 200%;
    animation: gradient 15s ease infinite;
}

@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
</style>
