<?php

namespace App\Http\Controllers;

use App\Models\AreaParkir;
use App\Models\AreaParkirDetail;
use App\Models\TipeKendaraan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AreaParkirController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = AreaParkir::with('details.tipeKendaraan')
                ->select('id','nama_area','lokasi');

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('kapasitas', function ($row) {
                    // total kapasitas = sum detail
                    return $row->details->sum('kapasitas');
                })

                ->addColumn('tipe_kendaraan', function ($row) {
                    // ambil nama tipe kendaraan semua detail
                    return $row->details->map(function($d) {
                        return $d->tipeKendaraan ? $d->tipeKendaraan->tipe_kendaraan : 'Unknown';
                    })->implode(', ');
                })

                ->addColumn('aksi', function ($row) {
                    return '
                        <div class="flex justify-center gap-2">
                            <a href="'.route('area-parkir.edit',$row->id).'"
                               class="text-blue-600 hover:underline text-sm">
                                Edit
                            </a>
                            <form action="'.route('area-parkir.destroy',$row->id).'" method="POST">
                                '.csrf_field().method_field('DELETE').'
                                <button class="text-red-600 hover:underline text-sm"
                                        onclick="return confirm(\'Yakin?\')">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    ';
                })

                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('area-parkir.index');
    }

    public function create()
    {
        // kirim semua tipe kendaraan untuk dropdown
        $tipeKendaraan = TipeKendaraan::all();
        return view('area-parkir.create', compact('tipeKendaraan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_area' => 'required',
            'lokasi'    => 'required',
            'tipe_kendaraan' => 'required|array|min:1',
            'kapasitas' => 'required|array|min:1',
        ]);

        DB::transaction(function () use ($request) {

            $area = AreaParkir::create([
                'nama_area'  => $request->nama_area,
                'lokasi'     => $request->lokasi,
                'created_by' => Auth::id(),
            ]);

            foreach ($request->tipe_kendaraan as $i => $idTipe) {
                if (!$idTipe) continue;

                AreaParkirDetail::create([
                    'area_parkir_id' => $area->id,
                    'id_tipe_kendaraan' => $idTipe,
                    'kapasitas'      => $request->kapasitas[$i],
                    'terisi'         => 0,
                    'created_by'     => Auth::id(),
                ]);
            }
        });

        return redirect()->route('area-parkir.index');
    }

    public function edit(AreaParkir $area_parkir)
    {
        $area_parkir->load('details');
        $tipeKendaraan = TipeKendaraan::all();
        return view('area-parkir.edit', ['area' => $area_parkir, 'tipeKendaraan' => $tipeKendaraan]);
    }

    public function update(Request $request, AreaParkir $area_parkir)
    {
        $request->validate([
            'nama_area' => 'required',
            'lokasi'    => 'required',
            'tipe_kendaraan' => 'required|array|min:1',
            'kapasitas' => 'required|array|min:1',
        ]);

        DB::transaction(function () use ($request, $area_parkir) {

            $area_parkir->update([
                'nama_area'  => $request->nama_area,
                'lokasi'     => $request->lokasi,
                'updated_by' => Auth::id(),
            ]);

            $existingDetails = $area_parkir->details->keyBy('id_tipe_kendaraan');

            foreach ($request->tipe_kendaraan as $i => $idTipe) {
                $kapasitas = $request->kapasitas[$i] ?? 0;

                if ($existingDetails->has($idTipe)) {
                    // update kapasitas jika ada
                    $detail = $existingDetails->get($idTipe);
                    $detail->update([
                        'kapasitas' => $kapasitas,
                        // terisi tetap sama
                        'updated_by' => Auth::id(),
                    ]);
                    $existingDetails->forget($idTipe); // tandai sudah diupdate
                } else {
                    // buat baru jika belum ada
                    AreaParkirDetail::create([
                        'area_parkir_id' => $area_parkir->id,
                        'id_tipe_kendaraan' => $idTipe,
                        'kapasitas'      => $kapasitas,
                        'terisi'         => 0,
                        'created_by'     => Auth::id(),
                    ]);
                }
            }

            // hapus detail yang sudah tidak ada di request, tapi pastikan terisi 0
            foreach ($existingDetails as $detail) {
                if ($detail->terisi > 0) {
                    abort(403, 'Tidak boleh menghapus tipe kendaraan yang sedang terisi');
                }
                $detail->delete();
            }
        });

        return redirect()->route('area-parkir.index');
    }

    public function destroy(AreaParkir $area)
    {
        DB::transaction(function () use ($area) {

            $existingDetails = AreaParkirDetail::where('area_parkir_id', $area->id)->get();

            foreach ($existingDetails as $detail) {
                if ($detail->terisi > 0) {
                    abort(403, 'Tidak boleh menghapus tipe kendaraan yang sedang terisi');
                }
            }

            AreaParkirDetail::where('area_parkir_id', $area->id)->delete();

            $area->update(['deleted_by' => Auth::id()]);
            $area->delete();
        });

        return redirect()->route('area-parkir.index');
    }
}
