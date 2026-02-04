<?php

namespace App\Http\Controllers;

use App\Models\AreaParkir;

class TrackAreaParkirController extends Controller
{
    public function index()
    {
        $areas = AreaParkir::with('details')->get()->map(function ($area) {

            $details = $area->details->map(function ($d) {

                $kapasitas = $d->kapasitas;
                $terisi    = $d->terisi ?? 0;
                $tersisa   = max($kapasitas - $terisi, 0);

                // kondisi per tipe kendaraan
                if ($terisi >= $kapasitas) {
                    $kondisi = 'Full';
                    $badge  = 'bg-red-500';
                } elseif ($terisi >= ($kapasitas * 0.9)) {
                    $kondisi = '90% Terpakai';
                    $badge  = 'bg-yellow-500';
                } else {
                    $kondisi = 'Tersedia';
                    $badge  = 'bg-green-500';
                }

                return [
                    'tipe_kendaraan' => $d->tipe_kendaraan,
                    'kapasitas'      => $kapasitas,
                    'terisi'         => $terisi,
                    'tersisa'        => $tersisa,
                    'kondisi'        => $kondisi,
                    'badge'          => $badge,
                ];
            });

            return [
                'nama_area' => $area->nama_area,
                'lokasi'    => $area->lokasi,
                'details'   => $details,
            ];
        });

        return view('track-area-parkir.index', compact('areas'));
    }
}
