<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjam extends Model
{
    public $table = 'peminjam';
    protected $fillable = [
        'nama_siswa',
        'kelas',
        'nama_barang',
        'jumlah_barang',
        'keterangan',
    ];

    public function dataSiswa()
    {
        return $this->belongsTo(DataSiswa::class, 'nis', 'nis');
    }

    public function dataBarang()
    {
        return $this->belongsTo(DataBarang::class, 'nama_barang', 'nama_barang');
    }
    public function getRouteKeyName()
    {
        return 'id';
    }
    public function getRouteKey()
    {
        return $this->id;
    }
    public function getNamaBarangAttribute($value)
    {
        return $this->dataBarang->nama_barang ?? $value;
    }
    public function getJumlahBarangAttribute($value)
    {
        return $this->dataBarang->jumlah_barang ?? $value;
    }
}
