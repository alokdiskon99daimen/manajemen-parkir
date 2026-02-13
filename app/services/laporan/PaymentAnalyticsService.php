<?php

namespace App\Services\Laporan;

use App\Models\Transaksi;

class PaymentAnalyticsService
{
    public function breakdown()
    {
        return Transaksi::where('status', 'keluar')
            ->join('tb_metode_pembayaran', 'tb_metode_pembayaran.id', '=', 'tb_transaksi.id_metode_pembayaran')
            ->selectRaw('
                tb_metode_pembayaran.metode_pembayaran as label,
                COUNT(*) as total_transaksi,
                SUM(tb_transaksi.biaya_total) as total_revenue
            ')
            ->groupBy('label')
            ->get();
    }
}
