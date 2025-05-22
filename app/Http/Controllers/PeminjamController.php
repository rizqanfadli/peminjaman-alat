<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use App\Models\DataBarang;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PeminjamController extends Controller
{
    public function index()
    {
        $peminjam = Peminjam::get();
        return Inertia::render('Peminjam/Index', [
            'peminjam' => $peminjam
        ]);
    }

    public function create()
    {
        return Inertia::render('Peminjam/Create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_siswa' => 'required',
        'kelas' => 'required',
        'tanggal_peminjaman' => 'required',
        'nama_barang' => 'required',
        'jumlah_barang' => 'required|integer|min:1',
        'keterangan' => 'nullable',
        'status' => 'required',
    ]);

    $barang = DataBarang::where('nama_barang', $request->nama_barang)->first();

    if (!$barang) {
        return back()->withErrors(['nama_barang' => 'Barang tidak ditemukan.']);
    }

    if ($request->jumlah_barang > $barang->jumlah_barang) {
        return back()->withErrors(['jumlah_barang' => 'Jumlah yang dipinjam melebihi stok yang tersedia!']);
    }

    // Kurangi stok
    $barang->jumlah_barang -= $request->jumlah_barang;
    $barang->save();

    Peminjam::create($request->all());

    return redirect()->route('peminjam.index')->with('success', 'Data peminjaman berhasil ditambahkan');
}


    public function edit(string $id)
    {
        $peminjam = Peminjam::find($id);
        return Inertia::render('Peminjam/Edit', [
            'peminjam' => $peminjam,
        ]);
    }

    public function update(Request $request, string $id)
{
    $request->validate([
        'nama_siswa' => 'required',
        'kelas' => 'required',
        'tanggal_peminjaman' => 'required',
        'nama_barang' => 'required',
        'jumlah_barang' => 'required|integer|min:1',
        'keterangan' => 'nullable',
        'status' => 'required',
    ]);

    $peminjam = Peminjam::findOrFail($id);
    $barang = DataBarang::where('nama_barang', $peminjam->nama_barang)->first();

    if (!$barang) {
        return back()->withErrors(['nama_barang' => 'Barang tidak ditemukan.']);
    }

    $selisih = $request->jumlah_barang - $peminjam->jumlah_barang;

    // Cek jika perubahan melebihi stok
    if ($selisih > 0 && $selisih > $barang->jumlah_barang) {
        return back()->withErrors(['jumlah_barang' => 'Perubahan jumlah pinjam melebihi stok yang tersedia!']);
    }

    // Update stok
    $barang->jumlah_barang -= $selisih;
    $barang->save();

    $peminjam->update($request->all());

    return redirect()->route('peminjam.index')->with('success', 'Data peminjaman berhasil diperbarui');
}


    public function destroy(string $id)
    {
        $peminjam = Peminjam::find($id);

        // Jika belum dikembalikan, maka kembalikan stok
        if ($peminjam->status !== 'Sudah Dikembalikan') {
            $barang = DataBarang::where('nama_barang', $peminjam->nama_barang)->first();
            if ($barang) {
                $barang->jumlah_barang += $peminjam->jumlah_barang;
                $barang->save();
            }
        }

        $peminjam->delete();

        return redirect()->route('peminjam.index')->with('success', 'Data peminjaman berhasil dihapus');
    }

    public function updateStatus(Request $request, Peminjam $peminjam)
    {
        $oldStatus = $peminjam->status;
        $newStatus = $request->input('status');
        $barang = DataBarang::where('nama_barang', $peminjam->nama_barang)->first();

        if ($barang) {
            if ($oldStatus === 'Dipinjam' && $newStatus === 'Sudah Dikembalikan') {
                $barang->jumlah_barang += $peminjam->jumlah_barang;
            }

            if ($oldStatus === 'Sudah Dikembalikan' && $newStatus === 'Dipinjam') {
                $barang->jumlah_barang -= $peminjam->jumlah_barang;
            }

            $barang->save();
        }

        $peminjam->status = $newStatus;
        $peminjam->save();

        return redirect()->route('peminjam.index')->with('success', 'Status dan stok barang berhasil diperbarui');
    }
}
