<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataKendaraan extends Model
{
    use SoftDeletes;

    protected $table = 'tb_data_kendaraan';

    protected $fillable = [
        'tipe_kendaraan',
        'plat_nomor',
        'warna',
        'pemilik',
        'aktif',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}