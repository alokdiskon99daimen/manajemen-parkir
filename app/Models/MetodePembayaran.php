<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MetodePembayaran extends Model
{
    use SoftDeletes;

    protected $table = 'tb_metode_pembayaran';

    protected $fillable = [
        'metode_pembayaran',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
