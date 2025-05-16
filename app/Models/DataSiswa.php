<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSiswa extends Model
{
    public $table = 'data_siswa';
    protected $fillable = [
        'nis',
        'nama',
        'kelas',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjam::class, 'nis', 'nis');
    }
    public function getRouteKeyName()
    {
        return 'nis';
    }
    public function getRouteKey()
    {
        return $this->nis;
    }
}
