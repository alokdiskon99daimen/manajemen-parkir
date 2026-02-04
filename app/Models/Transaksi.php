<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_transaksi';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_data_kendaraan',
        'waktu_masuk',
        'waktu_keluar',
        'id_tarif',
        'durasi_jam',
        'biaya',
        'biaya_total',
        'status',
        'id_user',
        'id_area',
        'id_metode_pembayaran',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'waktu_masuk'  => 'datetime',
        'waktu_keluar' => 'datetime',
        'biaya'        => 'decimal:0',
        'biaya_total'  => 'decimal:0',
    ];

    protected static function booted()
    {
        static::saving(function ($transaksi) {
            if (
                $transaksi->status === 'keluar' &&
                $transaksi->waktu_masuk &&
                $transaksi->waktu_keluar
            ) {
                $masuk  = Carbon::parse($transaksi->waktu_masuk);
                $keluar = Carbon::parse($transaksi->waktu_keluar);

                $durasiMenit = $masuk->diffInMinutes($keluar);

                $transaksi->durasi_jam = max(1, (int) ceil($durasiMenit / 60));
            }
        });
    }

    /**
     * =====================
     * RELATIONS
     * =====================
     */

    public function dataKendaraan()
    {
        return $this->belongsTo(DataKendaraan::class, 'id_data_kendaraan');
    }

    public function tarif()
    {
        return $this->belongsTo(Tarif::class, 'id_tarif');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function areaParkir()
    {
        return $this->belongsTo(AreaParkir::class, 'id_area');
    }

    public function metodePembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class, 'id_metode_pembayaran');
    }
}
