<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataKendaraan extends Model
{
    use SoftDeletes;

    protected $table = 'tb_data_kendaraan';

    protected $fillable = [
        'id_tipe_kendaraan',
        'plat_nomor',
        'warna',
        'pemilik',
        'aktif',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /* =====================
     | RELATIONSHIP
     ===================== */
    public function tipeKendaraan()
    {
        return $this->belongsTo(TipeKendaraan::class, 'id_tipe_kendaraan');
    }

    public function memberships()
    {
        return $this->belongsToMany(
            Membership::class,
            'tb_membership_kendaraan',
            'id_data_kendaraan',
            'id_membership'
        );
    }
}
