<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted, ref, watch } from 'vue';

const props = defineProps<{
    dataSiswa: Array<{ id: number; nis: string; nama: string; kelas: string }>;
    dataBarang: Array<{ id: number; nama_barang: string; jumlah_barang: number }>;
}>();

const showAlert = ref(false);
const isDarkMode = ref(false);
const selectedKelas = ref('');
const searchSiswa = ref('');
const showDropdown = ref(false);

let dotInterval: number | null = null;
let starInterval: number | null = null;

const form = useForm({
    nama_siswa: '',
    kelas: '',
    nama_barang: '',
    tanggal_peminjaman: new Date().toISOString().slice(0, 10),
    jumlah_pinjam: '',
    keterangan: '',
});

// Watch for changes in nama_siswa to update kelas
watch(
    () => form.nama_siswa,
    (newVal) => {
        const siswa = props.dataSiswa.find((s) => s.nama === newVal);
        form.kelas = siswa ? siswa.kelas : '';
    },
);

// Watch for changes in nama_barang to validate jumlah_pinjam
watch(
    () => form.nama_barang,
    (newVal) => {
        const barang = props.dataBarang.find((b) => b.nama_barang === newVal);
        if (barang) {
            if (Number(form.jumlah_pinjam) > barang.jumlah_barang) {
                form.jumlah_pinjam = '';
            }
        } else {
            form.jumlah_pinjam = '';
        }
    },
);

// Function to submit the form
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
            selectedKelas.value = '';
            searchSiswa.value = '';
            showDropdown.value = false;
        },
    });
}

// Function to filter students based on selected class and search term
const filteredSiswa = computed(() => {
    return props.dataSiswa.filter((siswa) => {
        return siswa.kelas === selectedKelas.value && siswa.nama.toLowerCase().includes(searchSiswa.value.toLowerCase());
    });
});

// Toggle dropdown visibility on input click
function toggleDropdown() {
    if (selectedKelas.value) {
        showDropdown.value = !showDropdown.value;
    }
}

// Select a student and close dropdown
function selectSiswa(siswa: { nama: string }) {
    form.nama_siswa = siswa.nama;
    searchSiswa.value = siswa.nama;
    showDropdown.value = false;
}

// Close dropdown when clicking outside input or dropdown
function handleClickOutside(event: MouseEvent) {
    const target = event.target as HTMLElement;
    const dropdownEl = document.querySelector('.dropdown');
    const inputEl = document.getElementById('nama_siswa_input');
    if (dropdownEl && inputEl && !dropdownEl.contains(target) && !inputEl.contains(target)) {
        showDropdown.value = false;
    }
}

function toggleTheme() {
    isDarkMode.value = !isDarkMode.value;
    localStorage.setItem('theme', isDarkMode.value ? 'dark' : 'light');
    updateHtmlClass();

    // Start or stop animation based on theme
    if (isDarkMode.value) {
        startAnimation();
    } else {
        stopAnimation();
    }
}

function updateHtmlClass() {
    if (isDarkMode.value) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
}

// Animation functions
function createFloatingDot() {
    if (!isDarkMode.value) return;

    const container = document.getElementById('animation-container');
    if (!container) return;

    const dot = document.createElement('div');
    dot.className = 'floating-dot';

    const size = Math.random() * 6 + 2;
    const posX = Math.random() * window.innerWidth;
    const duration = Math.random() * 20 + 15;
    const delay = Math.random() * 2;

    dot.style.width = `${size}px`;
    dot.style.height = `${size}px`;
    dot.style.left = `${posX}px`;
    dot.style.bottom = '-20px';
    dot.style.animationDuration = `${duration}s`;
    dot.style.animationDelay = `${delay}s`;

    container.appendChild(dot);

    setTimeout(
        () => {
            if (dot.parentNode === container) {
                container.removeChild(dot);
            }
        },
        (duration + delay) * 1000,
    );
}

function createShootingStar() {
    if (!isDarkMode.value) return;

    const container = document.getElementById('animation-container');
    if (!container) return;

    const star = document.createElement('div');
    star.className = 'shooting-star';

    const startY = Math.random() * (window.innerHeight / 3);
    const startX = Math.random() * (window.innerWidth / 2);
    const angle = Math.random() * 30 + 30;
    const size = Math.random() * 2 + 1;
    const duration = Math.random() * 2 + 3;

    star.style.top = `${startY}px`;
    star.style.left = `${startX}px`;
    star.style.transform = `rotate(${angle}deg)`;
    star.style.height = `${size}px`;
    star.style.width = `${size * 10}px`;
    star.style.animationDuration = `${duration}s`;

    container.appendChild(star);

    setTimeout(() => {
        if (star.parentNode === container) {
            container.removeChild(star);
        }
    }, duration * 1000);
}

function startAnimation() {
    if (dotInterval) clearInterval(dotInterval);
    if (starInterval) clearInterval(starInterval);

    // Create initial dots
    for (let i = 0; i < 8; i++) {
        setTimeout(() => createFloatingDot(), i * 500);
    }

    // Continue creating dots
    dotInterval = window.setInterval(createFloatingDot, 2000);

    // Create shooting stars
    starInterval = window.setInterval(createShootingStar, 3000);

    // Create first shooting star after delay
    setTimeout(createShootingStar, 1000);
}

function stopAnimation() {
    if (dotInterval) {
        clearInterval(dotInterval);
        dotInterval = null;
    }
    if (starInterval) {
        clearInterval(starInterval);
        starInterval = null;
    }

    // Clear existing animation elements
    const container = document.getElementById('animation-container');
    if (container) {
        container.innerHTML = '';
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside);

    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        isDarkMode.value = true;
    }
    updateHtmlClass();

    // Start animation if dark mode is active
    if (isDarkMode.value) {
        setTimeout(startAnimation, 100);
    }
});

onUnmounted(() => {
    stopAnimation();
    document.removeEventListener('click', handleClickOutside);
});
</script>

<template>
    <Head title="Peminjaman Alat TJKT" />

    <div class="relative min-h-screen bg-gray-50 transition-colors duration-500 dark:bg-gray-900 dark:text-white">
        <!-- Background Animation Container (only visible in dark mode) -->
        <div id="animation-container" class="pointer-events-none fixed inset-0 z-0 overflow-hidden" v-show="isDarkMode"></div>

        <div class="fixed top-4 right-4 z-50">
            <button
                @click="toggleTheme"
                class="rounded-lg border border-blue-300 bg-white px-4 py-1 text-sm text-blue-700 shadow hover:bg-blue-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700"
            >
                {{ isDarkMode ? 'Mode Terang' : 'Mode Gelap' }}
            </button>
        </div>

        <div class="relative z-10 py-10 text-center">
            <img src="/favicon.png" alt="Logo TJKT" class="mx-auto mb-4 h-20 w-20" />
            <h1 class="text-3xl font-extrabold text-blue-700 dark:text-blue-300">SMK N 2 Pengasih</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-300">Sistem peminjaman alat untuk siswa TJKT</p>
        </div>

        <main class="relative z-10 mx-auto max-w-3xl px-6 pb-16">
            <transition name="fade" appear>
                <div class="rounded-2xl bg-white p-8 shadow-lg ring-1 ring-blue-100 dark:bg-gray-800 dark:ring-gray-700">
                    <h2 class="mb-6 text-2xl font-semibold text-blue-700 dark:text-blue-200">Form Peminjaman</h2>

                    <form @submit.prevent="submit" class="space-y-6">
                        <div>
                            <Label for="kelas">Kelas</Label>
                            <select
                                id="kelas"
                                v-model="selectedKelas"
                                @change="form.kelas = selectedKelas"
                                class="mt-1 block w-full rounded-md border border-blue-200 bg-white p-2 text-gray-800 focus:border-blue-500 focus:ring focus:ring-blue-100 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100"
                                required
                            >
                                <option value="" disabled selected>Pilih Kelas</option>
                                <option v-for="kelas in [...new Set(props.dataSiswa.map((s) => s.kelas))]" :key="kelas" :value="kelas">
                                    {{ kelas }}
                                </option>
                            </select>
                            <InputError class="mt-1" :message="form.errors.kelas" />
                        </div>

                        <div>
                            <Label for="nama_siswa">Nama Peminjam</Label>
                            <div class="relative">
                                <input
                                    id="nama_siswa_input"
                                    type="text"
                                    v-model="searchSiswa"
                                    placeholder="Cari nama siswa..."
                                    class="mt-1 block w-full rounded-md border border-blue-200 bg-white p-2 text-gray-800 focus:border-blue-500 focus:ring focus:ring-blue-100 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100"
                                    @click="toggleDropdown"
                                    @input="form.nama_siswa = searchSiswa"
                                    autocomplete="off"
                                    :readonly="!selectedKelas"
                                />
                                <ul
                                    v-if="showDropdown && filteredSiswa.length > 0"
                                    class="dropdown absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md border border-blue-200 bg-white dark:bg-gray-800"
                                >
                                    <li
                                        v-for="siswa in filteredSiswa"
                                        :key="siswa.id"
                                        @click="selectSiswa(siswa)"
                                        class="cursor-pointer p-2 hover:bg-blue-100 dark:hover:bg-gray-700"
                                    >
                                        {{ siswa.nama }} ({{ siswa.kelas }})
                                    </li>
                                </ul>
                            </div>
                            <InputError class="mt-1" :message="form.errors.nama_siswa" />
                        </div>

                        <div>
                            <Label for="tanggal_peminjaman">Tanggal Peminjaman</Label>
                            <input
                                id="tanggal_peminjaman"
                                type="date"
                                v-model="form.tanggal_peminjaman"
                                class="mt-1 block w-full rounded-md border border-blue-200 bg-white p-2 text-gray-800 focus:border-blue-500 focus:ring focus:ring-blue-100 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100"
                                required
                            />
                            <InputError class="mt-1" :message="form.errors.tanggal_peminjaman" />
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
            class="relative z-10 border-t border-blue-100 bg-white py-6 text-center text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400"
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

/* Background Animation Styles - Only in Dark Mode */
#animation-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
    pointer-events: none;
    overflow: hidden;
}

:deep(.floating-dot) {
    position: absolute;
    background: radial-gradient(circle, rgba(96, 165, 250, 0.4) 0%, rgba(96, 165, 250, 0.1) 70%, transparent 100%);
    border-radius: 50%;
    animation: floatUp 15s linear forwards;
    box-shadow: 0 0 10px rgba(96, 165, 250, 0.3);
}

:deep(.shooting-star) {
    position: absolute;
    height: 2px;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
    border-radius: 2px;
    animation: shootAcross 4s linear forwards;
    opacity: 0;
    box-shadow: 0 0 8px rgba(255, 255, 255, 0.6);
}

:deep(.shooting-star::before) {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    width: 4px;
    height: 4px;
    background: radial-gradient(circle, rgba(255, 255, 255, 1) 0%, transparent 70%);
    border-radius: 50%;
    transform: translateY(-50%);
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
}

@keyframes floatUp {
    0% {
        transform: translateY(100vh) translateX(0px) rotate(0deg) scale(0.5);
        opacity: 0;
    }
    10% {
        opacity: 1;
    }
    90% {
        opacity: 1;
    }
    100% {
        transform: translateY(-100px) translateX(50px) rotate(360deg) scale(1);
        opacity: 0;
    }
}

@keyframes shootAcross {
    0% {
        transform: translateX(0) translateY(0) rotate(45deg);
        opacity: 0;
    }
    1% {
        opacity: 1;
    }
    20% {
        opacity: 1;
    }
    100% {
        transform: translateX(100vw) translateY(100vh) rotate(45deg);
        opacity: 0;
    }
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
