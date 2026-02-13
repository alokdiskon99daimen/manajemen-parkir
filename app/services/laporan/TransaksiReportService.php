<?php

namespace App\Services\Laporan;

use App\Models\Transaksi;
use Carbon\Carbon;
use DB;

class TransaksiReportService
{
    public function harian(Carbon $tanggal)
    {
        $query = Transaksi::whereDate('waktu_keluar', $tanggal)
            ->where('status', 'keluar');

        return [
            'total_transaksi' => $query->count(),
            'total_pendapatan' => $query->sum('biaya_total'),

            'by_tipe_kendaraan' => $query->clone()
                ->join('tb_data_kendaraan', 'tb_transaksi.id_data_kendaraan', '=', 'tb_data_kendaraan.id')
                ->join('tb_tipe_kendaraan', 'tb_data_kendaraan.id_tipe_kendaraan', '=', 'tb_tipe_kendaraan.id')
                ->select(
                    'tb_tipe_kendaraan.tipe_kendaraan',
                    DB::raw('COUNT(*) as total')
                )
                ->groupBy('tb_tipe_kendaraan.tipe_kendaraan')
                ->get(),

            'by_metode_pembayaran' => $query->clone()
                ->join('tb_metode_pembayaran', 'tb_transaksi.id_metode_pembayaran', '=', 'tb_metode_pembayaran.id')
                ->select(
                    'tb_metode_pembayaran.metode_pembayaran',
                    DB::raw('COUNT(*) as total'),
                    DB::raw('SUM(tb_transaksi.biaya_total) as nominal')
                )
                ->groupBy('tb_metode_pembayaran.metode_pembayaran')
                ->get(),
        ];
    }

    public function range(Carbon $start, Carbon $end)
    {
        $query = Transaksi::whereBetween('waktu_keluar', [$start, $end])
            ->where('status', 'keluar');

        return [
            'total_transaksi' => (clone $query)->count(),
            'total_pendapatan' => (clone $query)->sum('biaya_total'),

            'by_tipe_kendaraan' => (clone $query)
                ->join('tb_data_kendaraan', 'tb_transaksi.id_data_kendaraan', '=', 'tb_data_kendaraan.id')
                ->join('tb_tipe_kendaraan', 'tb_data_kendaraan.id_tipe_kendaraan', '=', 'tb_tipe_kendaraan.id')
                ->select('tb_tipe_kendaraan.tipe_kendaraan as tipe_kendaraan')
                ->selectRaw('COUNT(*) as total')
                ->groupBy('tb_tipe_kendaraan.tipe_kendaraan')
                ->get(),

            'by_metode_pembayaran' => (clone $query)
                ->join('tb_metode_pembayaran', 'tb_transaksi.id_metode_pembayaran', '=', 'tb_metode_pembayaran.id')
                ->select('tb_metode_pembayaran.metode_pembayaran as metode_pembayaran')
                ->selectRaw('COUNT(*) as total')
                ->selectRaw('SUM(biaya_total) as nominal')
                ->groupBy('tb_metode_pembayaran.metode_pembayaran')
                ->get(),
        ];
    }
}
