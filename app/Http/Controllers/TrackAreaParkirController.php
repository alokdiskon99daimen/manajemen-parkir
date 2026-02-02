<?php

namespace App\Http\Controllers;

use App\Models\AreaParkir;
use Illuminate\Http\Request;

class TrackAreaParkirController extends Controller
{
    public function index()
    {
        $areas = AreaParkir::with('detail')->get()->map(function ($area) {

            $kapasitas = $area->kapasitas;
            $terisi    = $area->detail->terisi ?? 0;
            $tersisa   = $kapasitas - $terisi;

            // kondisi
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
                'nama_area' => $area->nama_area,
                'lokasi'    => $area->lokasi,
                'kapasitas' => $kapasitas,
                'terisi'    => $terisi,
                'tersisa'   => $tersisa,
                'kondisi'   => $kondisi,
                'badge'     => $badge,
            ];
        });

        return view('track-area-parkir.index', compact('areas'));
    }
}
