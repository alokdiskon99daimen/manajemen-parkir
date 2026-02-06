<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipKendaraan extends Model
{
    protected $table = 'tb_membership_kendaraan';

    protected $fillable = [
        'id_membership',
        'id_data_kendaraan',
    ];
}
