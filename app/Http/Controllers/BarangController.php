<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $data_barang = DataBarang::get();
        
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


public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:csv,txt|max:2048',
    ]);

    $file = $request->file('file');
    $path = $file->getRealPath();
    $csvData = file_get_contents($path);
    $lines = explode(PHP_EOL, $csvData);

    $data = [];
    foreach ($lines as $line) {
        $row = str_getcsv($line, ';');

        // Lewati baris kosong
        if (count(array_filter($row)) === 0) continue;

        // Validasi jumlah kolom HARUS 2: nama_barang;jumlah_barang
        if (count($row) !== 2) {
            return Redirect::back()->withErrors(['file' => 'Format CSV tidak sesuai. Pastikan hanya ada 2 kolom: nama_barang;jumlah_barang']);
        }
        
//         if (!is_numeric(trim($row[1]))) {
//     return Redirect::back()->withErrors(['file' => 'Jumlah barang harus berupa angka.']);
// }

        $data[] = [
            'nama_barang' => trim($row[0]),
            'jumlah_barang' => (int) trim($row[1]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    if (empty($data)) {
        return Redirect::back()->withErrors(['file' => 'File kosong atau tidak memiliki data yang valid.']);
    }

    // Masukkan ke database
    DataBarang::insert($data);

    return redirect()->route('barang.index')->with('success', 'Data berhasil diimpor.');
}
}
