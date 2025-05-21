<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DataBarang::query();
        
        if ($request->has('nama_barang')) {
            $search = $request->nama_barang;
            $query->where('nama_barang', 'LIKE', "%{$search}%");
        }
        
        $data_barang = $query->get();
        
        return Inertia::render('Barang/Index', [
            'data_barang' => $data_barang
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Barang/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jumlah_barang' => 'required',
        ]);

        DataBarang::create([
            'nama_barang' => $request->nama_barang,
            'jumlah_barang' => $request->jumlah_barang,
        ]);
        return redirect()->route('barang.index')->with('success', 'Data Siswa berhasil ditambahkan');
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
        $data_barang = DataBarang::find($id);
        return Inertia::render('Barang/Edit', [
            'data_barang' => $data_barang,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jumlah_barang' => 'required',
        ]);

        $data_barang = DataBarang::find($id);
        $data_barang->nama_barang = $request->nama_barang;
        $data_barang->jumlah_barang = $request->jumlah_barang;
        $data_barang->save();

        return redirect()->route('barang.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data_barang = DataBarang::find($id);
        $data_barang->delete();

        return redirect()->route('barang.index');
    }
}
