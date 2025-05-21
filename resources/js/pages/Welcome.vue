<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Head, useForm } from '@inertiajs/vue3';
import { onMounted, ref, watch } from 'vue';

const props = defineProps<{
    dataSiswa: Array<{ id: number; nis: string; nama: string; kelas: string }>;
    dataBarang: Array<{ id: number; nama_barang: string; jumlah_barang: number }>;
    // form: any;
}>();

const showAlert = ref(false);
const isDarkMode = ref(false);

const form = useForm({
    nama_siswa: '',
    kelas: '',
    nama_barang: '',
    jumlah_pinjam: '', // diganti dari jumlah_barang jadi jumlah_pinjam
    keterangan: '',
});

watch(
    () => form.nama_siswa,
    (newVal) => {
        const siswa = props.dataSiswa.find((s) => s.nama === newVal);
        form.kelas = siswa ? siswa.kelas : '';
    },
);

watch(
    () => form.nama_barang,
    (newVal) => {
        const barang = props.dataBarang.find((b) => b.nama_barang === newVal);
        // Jangan isi jumlah_pinjam, tapi simpan stok barang yg tersedia untuk validasi
        if (barang) {
            // Jika jumlah_pinjam melebihi stok, reset jumlah_pinjam
            if (Number(form.jumlah_pinjam) > barang.jumlah_barang) {
                form.jumlah_pinjam = '';
            }
        } else {
            form.jumlah_pinjam = '';
        }
    },
);

function submit() {
    const barang = props.dataBarang.find((b) => b.nama_barang === form.nama_barang);
    if (!barang) {
        alert('Pilih barang yang valid.');
        return;
    }
    if (Number(form.jumlah_pinjam) > barang.jumlah_barang) {
        alert('Jumlah pinjam tidak boleh melebihi stok barang tersedia.');
        return;
    }
    form.post(route('form.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            showAlert.value = true;
            setTimeout(() => (showAlert.value = false), 5000);
        },
    });
}

onMounted(() => {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') isDarkMode.value = true;
    updateHtmlClass();
});

function toggleTheme() {
    isDarkMode.value = !isDarkMode.value;
    localStorage.setItem('theme', isDarkMode.value ? 'dark' : 'light');
    updateHtmlClass();
}

function updateHtmlClass() {
    if (isDarkMode.value) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
}
</script>

<template>
    <Head title="Peminjaman Alat TJKT" />

    <div class="relative min-h-screen bg-gray-50 transition-colors duration-500 dark:bg-gray-900 dark:text-white">
        <!-- Tombol mode gelap di kanan atas -->
        <div class="fixed top-4 right-4 z-50">
            <button
                @click="toggleTheme"
                class="rounded-lg border border-blue-300 bg-white px-4 py-1 text-sm text-blue-700 shadow hover:bg-blue-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700"
            >
                {{ isDarkMode ? 'Mode Terang' : 'Mode Gelap' }}
            </button>
        </div>

        <!-- Background animation -->
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div
                class="animate-pulse-slow absolute top-0 left-1/2 h-[150%] w-[200%] -translate-x-1/2 rotate-45 bg-gradient-to-br from-blue-100 via-white to-blue-200 opacity-40 dark:from-blue-800 dark:via-gray-900 dark:to-gray-800"
            ></div>
        </div>

        <div class="py-10 text-center">
            <img src="/storage/Logo/TKJ.png" alt="Logo TJKT" class="mx-auto mb-4 h-20 w-20" />
            <h1 class="text-3xl font-extrabold text-blue-700 dark:text-blue-300">SMK N 2 Pengasih</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-300">Sistem peminjaman alat untuk siswa TJKT</p>
        </div>

        <main class="mx-auto max-w-3xl px-6 pb-16">
            <transition name="fade" appear>
                <div class="rounded-2xl bg-white p-8 shadow-lg ring-1 ring-blue-100 dark:bg-gray-800 dark:ring-gray-700">
                    <h2 class="mb-6 text-2xl font-semibold text-blue-700 dark:text-blue-200">Form Peminjaman</h2>

                    <form @submit.prevent="submit" class="space-y-6">
                        <div>
                            <Label for="nama_siswa">Nama Peminjam</Label>
                            <select
                                id="nama_siswa"
                                v-model="form.nama_siswa"
                                class="mt-1 block w-full rounded-md border border-blue-200 bg-white p-2 text-gray-800 focus:border-blue-500 focus:ring focus:ring-blue-100 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100"
                                required
                            >
                                <option value="" disabled selected>Pilih Nama Siswa</option>
                                <option v-for="siswa in dataSiswa" :key="siswa.id" :value="siswa.nama">{{ siswa.nama }} ({{ siswa.kelas }})</option>
                            </select>
                            <InputError class="mt-1" :message="form.errors.nama_siswa" />
                        </div>

                        <div>
                            <Label for="kelas">Kelas</Label>
                            <input
                                id="kelas"
                                type="text"
                                v-model="form.kelas"
                                readonly
                                class="mt-1 block w-full rounded-md border border-blue-200 bg-gray-100 p-2 text-gray-600 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300"
                            />
                            <InputError class="mt-1" :message="form.errors.kelas" />
                        </div>

                        <div>
                            <Label for="nama_barang">Nama Barang</Label>
                            <select
                                id="nama_barang"
                                v-model="form.nama_barang"
                                class="mt-1 block w-full rounded-md border border-blue-200 bg-white p-2 text-gray-800 focus:border-blue-500 focus:ring focus:ring-blue-100 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100"
                                required
                            >
                                <option value="" disabled selected>Pilih Barang</option>
                                <option v-for="barang in dataBarang" :key="barang.id" :value="barang.nama_barang">
                                    {{ barang.nama_barang }}
                                </option>
                            </select>
                            <InputError class="mt-1" :message="form.errors.nama_barang" />
                        </div>

                        <div>
                            <Label for="jumlah_pinjam">Jumlah Pinjam (stok tersedia)</Label>
                            <input
                                id="jumlah_pinjam"
                                type="number"
                                v-model="form.jumlah_pinjam"
                                min="1"
                                :max="dataBarang.find((b) => b.nama_barang === form.nama_barang)?.jumlah_barang || 0"
                                required
                                class="mt-1 block w-full rounded-md border border-blue-200 bg-white p-2 text-gray-800 focus:border-blue-500 focus:ring focus:ring-blue-100 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100"
                            />
                            <InputError class="mt-1" :message="form.errors.jumlah_pinjam" />
                        </div>

                        <div>
                            <Label for="keterangan">Keterangan (opsional)</Label>
                            <textarea
                                id="keterangan"
                                v-model="form.keterangan"
                                rows="3"
                                placeholder="Misal: untuk praktik di lab"
                                class="mt-1 w-full rounded-md border border-blue-200 p-2 focus:border-blue-400 focus:ring focus:ring-blue-100 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100"
                            ></textarea>
                            <InputError class="mt-1" :message="form.errors.keterangan" />
                        </div>

                        <div class="text-right">
                            <Button type="submit" class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                                Ajukan Peminjaman
                            </Button>
                        </div>

                        <transition name="fade">
                            <div
                                v-if="showAlert"
                                class="rounded-md bg-green-100 px-4 py-3 text-green-800 ring-1 ring-green-300 dark:bg-green-900 dark:text-green-200"
                            >
                                Peminjaman berhasil dikirim!
                            </div>
                        </transition>
                    </form>
                </div>
            </transition>
        </main>

        <footer
            class="border-t border-blue-100 bg-white py-6 text-center text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400"
        >
            &copy; {{ new Date().getFullYear() }} Sistem Peminjaman Alat TJKT. All rights reserved.
        </footer>
    </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.6s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

@keyframes pulse-slow {
    0%,
    100% {
        transform: scale(1);
        opacity: 0.4;
    }
    50% {
        transform: scale(1.05);
        opacity: 0.6;
    }
}
.animate-pulse-slow {
    animation: pulse-slow 10s ease-in-out infinite;
}
</style>
