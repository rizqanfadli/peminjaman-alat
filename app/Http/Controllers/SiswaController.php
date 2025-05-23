<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {        
        $data_siswa = DataSiswa::get();
        
        return Inertia::render('Siswa/Index', [
            'data_siswa' => $data_siswa,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Siswa/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kelas' => 'required',
        ]);

        DataSiswa::create([
            'nama' => $request->nama,
            'kelas' => $request->kelas,
        ]);
        return redirect()->route('siswa.index')->with('success', 'Data Siswa berhasil ditambahkan');
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
        $siswa = DataSiswa::find($id);
        return Inertia::render('Siswa/Edit', [
            'siswa' => $siswa,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required',
            'kelas' => 'required',
        ]);

        $siswa = DataSiswa::find($id);
        $siswa->nama = $request->nama;
        $siswa->kelas = $request->kelas;
        $siswa->save();

        return redirect()->route('siswa.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $siswa = DataSiswa::find($id);
        $siswa->delete();

        return redirect()->route('siswa.index');
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
    // Lewati baris kosong
    if (trim($line) === '') continue;

    // $row = str_getcsv($line, ';');
    $row = array_map(function ($value) {
    return trim(trim($value), ',');
}, str_getcsv($line, ';'));

    // Hilangkan elemen kosong di akhir (trailing empty columns)
    $row = array_map('trim', $row);
    $row = array_filter($row, fn($val) => $val !== '');

    // Pastikan hanya dua kolom
    if (count($row) !== 2) {
        continue; // Atau log error jika ingin tahu baris mana yang tidak sesuai
    }

    [$nama, $kelas] = $row;

    // Tambahkan validasi konten jika perlu
    if (empty($nama) || empty($kelas)) continue;

    $data[] = [
        'nama' => $nama,
        'kelas' => $kelas,
        'created_at' => now(),
        'updated_at' => now(),
    ];
}

// Optionally, insert the data into the database if needed
if (!empty($data)) {
    DataSiswa::insert($data);
}

return redirect()->route('siswa.index')->with('success', 'Data Siswa berhasil diimpor');
    }
}