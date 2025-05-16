<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataBarang extends Model
{
    public $table = 'data_barang';
    protected $fillable = [
        'nama_barang',
        'gambar_barang',
        'jumlah_barang',
    ];
}
