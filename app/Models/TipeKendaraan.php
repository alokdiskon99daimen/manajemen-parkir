<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipeKendaraan extends Model
{
    use SoftDeletes;

    protected $table = 'tb_tipe_kendaraan';

    protected $fillable = [
        'tipe_kendaraan',
        'kapasitas',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function areaParkir()
    {
        return $this->belongsToMany(
            AreaParkir::class,
            'tb_area_tipe_kendaraan',
            'id_tipe_kendaraan',
            'id_area'
        );
    }
    
    public function tarif()
    {
        return $this->hasOne(Tarif::class, 'id_tipe_kendaraan');
    }

    public function areaDetails()
    {
        return $this->hasMany(AreaParkirDetail::class, 'id_tipe_kendaraan');
    }
}
