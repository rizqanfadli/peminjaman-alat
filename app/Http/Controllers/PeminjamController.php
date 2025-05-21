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
        
        $peminjam = Peminjam::get();
        
        return Inertia::render('Peminjam/Index', [
            'peminjam' => $peminjam
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
            'tanggal_peminjaman' => 'required', 
            'nama_barang' => 'required',
            'jumlah_barang' => 'required',
            'keterangan' => 'nullable',
            'status' => 'required',
        ]);

        Peminjam::create([
            'nama_siswa' => $request->nama_siswa,
            'kelas' => $request->kelas,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'nama_barang' => $request->nama_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
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
            'tanggal_peminjaman' => 'required', 
            'nama_barang' => 'required',
            'jumlah_barang' => 'required',
            'keterangan' => 'nullable',
            'status' => 'required',
        ]);

        $peminjam = Peminjam::find($id);
        $peminjam->nama_siswa = $request->nama_siswa;
        $peminjam->kelas = $request->kelas;
        $peminjam->tanggal_peminjaman = $request->tanggal_peminjaman;
        $peminjam->nama_barang = $request->nama_barang;
        $peminjam->jumlah_barang = $request->jumlah_barang;
        $peminjam->keterangan = $request->keterangan;
        $peminjam->status = $request->status;
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

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, Peminjam $peminjam)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:Dipinjam,Sudah Dikembalikan'],
        ]);

        $peminjam->update([
            'status' => $validated['status']
        ]);

        return redirect()->back()
            ->with('message', 'Status berhasil diperbarui');
    }
}
