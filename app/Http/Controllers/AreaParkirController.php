<?php

namespace App\Http\Controllers;

use App\Models\AreaParkir;
use App\Models\AreaParkirDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AreaParkirController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = AreaParkir::with('details')
                ->select('id','nama_area','lokasi');

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('kapasitas', function ($row) {
                    // total kapasitas = sum detail
                    return $row->details->sum('kapasitas');
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
        return view('area-parkir.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_area' => 'required',
            'lokasi'    => 'required',
        ]);

        if (!$request->tipe_kendaraan || count(array_filter($request->tipe_kendaraan)) == 0) {
            return back()
                ->withErrors(['tipe_kendaraan' => 'Minimal 1 tipe kendaraan'])
                ->withInput();
        }

        DB::transaction(function () use ($request) {

            $area = AreaParkir::create([
                'nama_area'  => $request->nama_area,
                'lokasi'     => $request->lokasi,
                'created_by' => Auth::id(),
            ]);

            foreach ($request->tipe_kendaraan as $i => $tipe) {
                if (!$tipe) continue;

                AreaParkirDetail::create([
                    'area_parkir_id' => $area->id,
                    'tipe_kendaraan' => $tipe,
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
        return view('area-parkir.edit', ['area' => $area_parkir]);
    }

    public function update(Request $request, AreaParkir $area_parkir)
    {
        $request->validate([
            'nama_area' => 'required',
            'lokasi'    => 'required',
        ]);

        if (!$request->tipe_kendaraan || count(array_filter($request->tipe_kendaraan)) == 0) {
            return back()
                ->withErrors(['tipe_kendaraan' => 'Minimal 1 tipe kendaraan'])
                ->withInput();
        }

        DB::transaction(function () use ($request, $area_parkir) {

            $area_parkir->update([
                'nama_area'  => $request->nama_area,
                'lokasi'     => $request->lokasi,
                'updated_by' => Auth::id(),
            ]);

            AreaParkirDetail::where('area_parkir_id', $area_parkir->id)->delete();

            foreach ($request->tipe_kendaraan as $i => $tipe) {
                if (!$tipe) continue;

                AreaParkirDetail::create([
                    'area_parkir_id' => $area_parkir->id,
                    'tipe_kendaraan' => $tipe,
                    'kapasitas'      => $request->kapasitas[$i],
                    'terisi'         => 0,
                    'created_by'     => Auth::id(),
                ]);
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
                    // pastikan masih ada di request
                    if (!in_array($detail->tipe_kendaraan, $request->tipe_kendaraan)) {
                        abort(403, 'Tidak boleh menghapus tipe kendaraan yang sedang terisi');
                    }
                }
            }

            AreaParkirDetail::where('area_parkir_id', $area->id)->delete();

            $area->update([
                'deleted_by' => Auth::id()
            ]);

            $area->delete();
        });

        return redirect()->route('area-parkir.index');
    }
}
