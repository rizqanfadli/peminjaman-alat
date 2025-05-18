<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PeminjamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peminjam = Peminjam::all();
        return Inertia::render('Peminjam/Index', [
            'peminjam' => $peminjam,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Peminjam/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required',
            'kelas' => 'required', 
            'nama_barang' => 'required',
            'jumlah_barang' => 'required',
            'keterangan' => 'nullable',
        ]);

        Peminjam::create([
            'nama_siswa' => $request->nama_siswa,
            'kelas' => $request->kelas,
            'nama_barang' => $request->nama_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('peminjam.index')->with('success', 'Data peminjaman berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $peminjam = Peminjam::find($id);
        return Inertia::render('Peminjam/Edit', [
            'peminjam' => $peminjam,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_siswa' => 'required',
            'kelas' => 'required', 
            'nama_barang' => 'required',
            'jumlah_barang' => 'required',
            'keterangan' => 'nullable',
        ]);

        $peminjam = Peminjam::find($id);
        $peminjam->nama_siswa = $request->nama_siswa;
        $peminjam->kelas = $request->kelas;
        $peminjam->nama_barang = $request->nama_barang;
        $peminjam->jumlah_barang = $request->jumlah_barang;
        $peminjam->keterangan = $request->keterangan;
        $peminjam->save();

        return redirect()->route('peminjam.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $peminjam = Peminjam::find($id);
        $peminjam->delete();

        return redirect()->route('peminjam.index');
    }
}
