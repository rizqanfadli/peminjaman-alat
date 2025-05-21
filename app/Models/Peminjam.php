<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjam extends Model
{
    public $table = 'peminjam';
    protected $fillable = [
        'nama_siswa',
        'kelas',
        'tanggal_peminjaman',
        'nama_barang', 
        'jumlah_barang',
        'keterangan',
        'status',
    ];
}
