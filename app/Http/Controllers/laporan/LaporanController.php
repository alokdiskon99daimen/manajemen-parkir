<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Services\Laporan\TransaksiReportService;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    protected $service;

    public function __construct(TransaksiReportService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('laporan.index');
    }

    public function harian()
    {
        $tanggal = Carbon::today();
        $data = $this->service->harian($tanggal);

        return view('laporan.harian', compact('data', 'tanggal'));
    }

    public function range(Request $request)
    {
        // validasi optional
        $request->validate([
            'start' => 'nullable|date',
            'end'   => 'nullable|date|after_or_equal:start',
        ]);

        // default value (biar blade aman)
        $start = $request->filled('start')
            ? Carbon::parse($request->start)->startOfDay()
            : Carbon::today()->startOfDay();

        $end = $request->filled('end')
            ? Carbon::parse($request->end)->endOfDay()
            : Carbon::today()->endOfDay();

        $data = $this->service->range($start, $end);

        return view('laporan.range', compact(
            'data',
            'start',
            'end'
        ));
    }

    public function uiMockup()
    {
        return view('laporan.ui-mockup');
    }
}
