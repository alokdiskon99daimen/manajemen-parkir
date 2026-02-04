<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembershipTier extends Model
{
    use SoftDeletes;

    protected $table = 'tb_membership_tier';

    protected $fillable = [
        'tier',
        'harga',
        'diskon',
        'free_entry',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
