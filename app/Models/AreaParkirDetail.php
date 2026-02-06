<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaParkirDetail extends Model
{
    use SoftDeletes;

    protected $table = 'tb_area_parkir_detail';

    protected $fillable = [
        'area_parkir_id',
        'id_tipe_kendaraan',
        'kapasitas',
        'terisi',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function area()
    {
        return $this->belongsTo(AreaParkir::class, 'area_parkir_id');
    }

    public function tipeKendaraan()
    {
        return $this->belongsTo(TipeKendaraan::class, 'id_tipe_kendaraan');
    }
}

