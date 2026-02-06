<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarif extends Model
{
    use SoftDeletes;

    protected $table = 'tb_tarif';

    protected $fillable = [
        'id_tipe_kendaraan',
        'tarif_per_jam',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function tipeKendaraan()
    {
        return $this->belongsTo(TipeKendaraan::class, 'id_tipe_kendaraan');
    }
}