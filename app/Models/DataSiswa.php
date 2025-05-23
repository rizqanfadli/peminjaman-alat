<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSiswa extends Model
{
    public $table = 'data_siswa';
    protected $fillable = [
        'nama',
        'kelas',
    ];
}
