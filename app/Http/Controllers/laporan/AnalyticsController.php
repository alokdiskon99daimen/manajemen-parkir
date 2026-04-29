<?php

namespace App\Http\Controllers\laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->start_date
            ? Carbon::parse($request->start_date)->startOfDay()
            : now()->subDays(30)->startOfDay();

        $end = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : now()->endOfDay();

        // Revenue Harian
        $revenueHarian = Transaksi::select(
                DB::raw('DATE(waktu_keluar) as tanggal'),
                DB::raw('SUM(biaya_total) as total_revenue')
            )
            ->where('status', 'keluar')
            ->whereBetween('waktu_keluar', [$start, $end])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Peak Hour
        $peakHour = Transaksi::select(
                DB::raw('HOUR(waktu_keluar) as jam'),
                DB::raw('COUNT(*) as total_transaksi')
            )
            ->where('status', 'keluar')
            ->whereBetween('waktu_keluar', [$start, $end])
            ->groupBy('jam')
            ->orderByDesc('total_transaksi')
            ->get();

        // Payment Method
        $paymentAnalysis = Transaksi::with('metodePembayaran')
            ->where('status', 'keluar')
            ->whereBetween('waktu_keluar', [$start, $end])
            ->select(
                'id_metode_pembayaran',
                DB::raw('SUM(biaya_total) as total_revenue')
            )
            ->groupBy('id_metode_pembayaran')
            ->get()
            ->map(function ($item) {
                return [
                    'metode' => $item->metodePembayaran->metode_pembayaran ?? 'Unknown',
                    'revenue' => $item->total_revenue,
                ];
            });
        $totalRevenue = Transaksi::where('status','keluar')
        ->whereBetween('waktu_keluar', [$start, $end])
        ->sum('biaya_total');

        $totalTransaksi = Transaksi::where('status','keluar')
            ->whereBetween('waktu_keluar', [$start, $end])
            ->count();

        $avgTicket = $totalTransaksi > 0
            ? $totalRevenue / $totalTransaksi
            : 0;

        $memberRevenue = Transaksi::leftJoin(
                'tb_membership_kendaraan as mk',
                'tb_transaksi.id_data_kendaraan',
                '=',
                'mk.id_data_kendaraan'
            )
            ->select(
                DB::raw('IF(mk.id_membership IS NULL, "Non Member", "Member") as tipe'),
                DB::raw('SUM(tb_transaksi.biaya_total) as total')
            )
            ->where('tb_transaksi.status', 'keluar')
            ->whereBetween('tb_transaksi.waktu_keluar', [$start, $end])
            ->groupBy('tipe')
            ->get();
        return view('analytics.index', compact(
            'revenueHarian',
            'peakHour',
            'paymentAnalysis',
            'start',
            'end',
            'totalRevenue',
            'totalTransaksi',
            'avgTicket',
            'memberRevenue'
        ));
    }
}