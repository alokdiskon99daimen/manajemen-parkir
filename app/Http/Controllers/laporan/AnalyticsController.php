<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Services\Laporan\{
    RevenueAnalyticsService,
    PeakHourService,
    MemberAnalyticsService,
    VehicleAnalyticsService,
    PaymentAnalyticsService,
    OccupancyAnalyticsService
};

class AnalyticsController extends Controller
{
    public function index(
        RevenueAnalyticsService $revenue,
        PeakHourService $peak,
        MemberAnalyticsService $member,
        VehicleAnalyticsService $vehicle,
        PaymentAnalyticsService $payment,
        OccupancyAnalyticsService $occupancy
    ) {
        return view('laporan.analytics', [
            'revenueDaily'   => $revenue->perHari(),
            'revenueByType'  => $revenue->byTipeKendaraan(),
            'peakHour'       => $peak->traffic(),
            'memberSummary'  => $member->summary(),
            'vehicleDist'    => $vehicle->distribution(),
            'paymentData'    => $payment->breakdown(),
            'occupancyRate'  => $occupancy->rate(),
        ]);
    }

    public function exportCsv(
        RevenueAnalyticsService $revenue,
        VehicleAnalyticsService $vehicle,
        PaymentAnalyticsService $payment
    ) {
        $filename = 'laporan-analytics-' . now()->format('Ymd_His') . '.csv';

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($revenue, $vehicle, $payment) {
            $file = fopen('php://output', 'w');

            // ================= Revenue =================
            fputcsv($file, ['Revenue Harian']);
            fputcsv($file, ['Tanggal', 'Total']);

            foreach ($revenue->perHari() as $row) {
                fputcsv($file, [$row->tanggal, $row->total]);
            }

            fputcsv($file, []); // spacer

            // ================= Kendaraan =================
            fputcsv($file, ['Distribusi Kendaraan']);
            fputcsv($file, ['Tipe Kendaraan', 'Jumlah']);

            foreach ($vehicle->distribution() as $row) {
                fputcsv($file, [$row->label, $row->total]);
            }

            fputcsv($file, []);

            // ================= Payment =================
            fputcsv($file, ['Metode Pembayaran']);
            fputcsv($file, ['Metode', 'Transaksi', 'Revenue']);

            foreach ($payment->breakdown() as $row) {
                fputcsv($file, [
                    $row->label,
                    $row->total_transaksi,
                    $row->total_revenue
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
