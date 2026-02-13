<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diskon extends Model
{
    use SoftDeletes;

    protected $table = 'tb_diskon';

    protected $fillable = [
        'nama_diskon',
        'diskon',
        'waktu_mulai',
        'waktu_selesai',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'waktu_mulai'   => 'date',
        'waktu_selesai' => 'date',
    ];
}