<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DataKendaraan;
use App\Models\MembershipKendaraan;

class Membership extends Model
{
    use SoftDeletes;

    protected $table = 'tb_membership';

    protected $fillable = [
        'nama_lengkap',
        'membership_tier_id',
        'loyalty_point',
        'free_entry_quota',
        'last_renewal',
        'expired',
        'aktif',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'last_renewal' => 'datetime',
        'expired' => 'datetime',
    ];

    public function tier()
    {
        return $this->belongsTo(MembershipTier::class, 'membership_tier_id');
    }

    public function kendaraan()
    {
        return $this->belongsToMany(
            DataKendaraan::class,
            'tb_membership_kendaraan',
            'id_membership',
            'id_data_kendaraan'
        );
    }
}
