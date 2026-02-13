<?php

namespace App\Services\Laporan;

use App\Models\Transaksi;

class MemberAnalyticsService
{
    public function summary()
    {
        $memberQuery = Transaksi::whereHas('dataKendaraan.memberships')
            ->where('status', 'keluar');

        $nonMemberQuery = Transaksi::whereDoesntHave('dataKendaraan.memberships')
            ->where('status', 'keluar');

        return [
            'total_member'       => $memberQuery->count(),
            'total_non_member'   => $nonMemberQuery->count(),
            'revenue_member'     => $memberQuery->sum('biaya_total'),
            'revenue_non_member' => $nonMemberQuery->sum('biaya_total'),
        ];
    }
}
