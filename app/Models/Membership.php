<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Membership extends Model
{
    use SoftDeletes;

    protected $table = 'tb_membership';

    protected $fillable = [
        'nama_lengkap',
        'membership_tier_id',
        'loyalty_point',
        'last_renewal',
        'expired',
        'aktif',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function tier()
    {
        return $this->belongsTo(MembershipTier::class, 'membership_tier_id');
    }
}
