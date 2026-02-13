<?php

namespace App\Http\Controllers;

use App\Models\AreaParkir;

class TrackAreaParkirController extends Controller
{
    private function buildAreaData()
    {
        return AreaParkir::with('details.tipeKendaraan')->get()->map(function ($area) {

            $details = $area->details->map(function ($d) {

                $kapasitas = $d->kapasitas;
                $terisi    = $d->terisi ?? 0;
                $tersisa   = max($kapasitas - $terisi, 0);

                if ($terisi >= $kapasitas) {
                    $kondisi = 'Full';
                    $badge   = 'bg-red-500';
                } elseif ($terisi >= ($kapasitas * 0.9)) {
                    $kondisi = '90% Terpakai';
                    $badge   = 'bg-yellow-500';
                } else {
                    $kondisi = 'Tersedia';
                    $badge   = 'bg-green-500';
                }

                return [
                    'tipe_kendaraan' => $d->tipeKendaraan->tipe_kendaraan ?? 'Unknown',
                    'kapasitas'      => $kapasitas,
                    'terisi'         => $terisi,
                    'tersisa'        => $tersisa,
                    'kondisi'        => $kondisi,
                    'badge'          => $badge,
                    'persentase_terisi' => $terisi / $kapasitas * 100,
                ];
            });

            return [
                'nama_area' => $area->nama_area,
                'lokasi'    => $area->lokasi,
                'details'   => $details,
            ];
        });
    }

    public function index()
    {
        $areas = $this->buildAreaData();
        return view('track-area-parkir.index', compact('areas'));
    }

    public function monitoring()
    {
        $areas = $this->buildAreaData();
        return view('track-area-parkir.monitoring', compact('areas'));
    }

    public function data()
    {
        return response()->json($this->buildAreaData());
    }
}
