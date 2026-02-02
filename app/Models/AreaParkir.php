<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaParkir extends Model
{
    use SoftDeletes;

    protected $table = 'tb_area_parkir';

    protected $fillable = [
        'nama_area',
        'lokasi',
        'kapasitas',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function detail()
    {
        return $this->hasOne(AreaParkirDetail::class, 'area_parkir_id');
    }
}
