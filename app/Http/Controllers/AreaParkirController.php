<?php

namespace App\Http\Controllers;

use App\Models\AreaParkir;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class AreaParkirController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AreaParkir::select(
                'id','nama_area','lokasi','kapasitas'
            );

            return DataTables::of($data)
                ->addIndexColumn()
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
        AreaParkir::create([
            'nama_area' => $request->nama_area,
            'lokasi'    => $request->lokasi,
            'kapasitas' => $request->kapasitas,
            'created_by'=> Auth::user()->name ?? 'system',
        ]);

        return redirect()->route('area-parkir.index');
    }

    public function edit(AreaParkir $area)
    {
        return view('area-parkir.edit', compact('area'));
    }

    public function update(Request $request, AreaParkir $area)
    {
        $area->update([
            'nama_area' => $request->nama_area,
            'lokasi'    => $request->lokasi,
            'kapasitas' => $request->kapasitas,
            'updated_by'=> Auth::user()->name ?? 'system',
        ]);

        return redirect()->route('area-parkir.index');
    }

    public function destroy(AreaParkir $area)
    {
        $area->update([
            'deleted_by' => Auth::user()->name ?? 'system'
        ]);

        $area->delete();

        return redirect()->route('area-parkir.index');
    }
}
