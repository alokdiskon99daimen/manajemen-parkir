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
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
