<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use App\Models\DataSiswa;
use App\Models\DataBarang;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FormController extends Controller
{
    public function index()
    {
        // Ambil data siswa dan barang dari tabel masing-masing
        $dataSiswa = DataSiswa::all();
        $dataBarang = DataBarang::all();

        // Ambil data peminjaman juga kalau perlu (misal untuk daftar peminjam)
        $form = Peminjam::all();

        // Kirim data ke Inertia untuk dipakai di Welcome.vue
        return Inertia::render('Welcome', [
            'dataSiswa' => $dataSiswa,
            'dataBarang' => $dataBarang,
            'form' => $form,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required',
            'kelas' => 'required',
            'nama_barang' => 'required',
            'jumlah_pinjam' => 'required|integer|min:1',
            'keterangan' => 'nullable',
        ]);

        // Cek stok barang tersedia
        $barang = DataBarang::where('nama_barang', $request->nama_barang)->first();
        if (!$barang) {
            return back()->withErrors(['nama_barang' => 'Barang tidak ditemukan']);
        }
        if ($barang->jumlah_barang < $request->jumlah_pinjam) {
            return back()->withErrors(['jumlah_pinjam' => 'Jumlah pinjam melebihi stok barang']);
        }

        // Kurangi stok barang
        $barang->jumlah_barang -= $request->jumlah_pinjam;
        $barang->save();

        // Simpan data peminjaman
        Peminjam::create([
            'nama_siswa' => $request->nama_siswa,
            'kelas' => $request->kelas,
            'nama_barang' => $request->nama_barang,
            'jumlah_barang' => $request->jumlah_pinjam,  // simpan jumlah pinjam
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('form.index')->with('success', 'Peminjaman berhasil disimpan.');
    }
}
