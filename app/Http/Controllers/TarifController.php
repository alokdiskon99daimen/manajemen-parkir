<?php

namespace App\Http\Controllers;

use App\Models\Tarif;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class TarifController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Tarif::select('id', 'tipe_kendaraan', 'tarif_per_jam');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tarif_per_jam', function ($row) {
                    return 'Rp ' . number_format($row->tarif_per_jam, 0, ',', '.');
                })
                ->addColumn('aksi', function ($row) {
                    return '
                        <div class="flex justify-center gap-2">
                            <a href="'.route('tarif.edit',$row->id).'"
                            class="text-blue-600 hover:underline text-sm">
                            Edit
                            </a>
                            <form action="'.route('tarif.destroy',$row->id).'" method="POST">
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

        return view('tarif.index');
    }

    public function create()
    {
        return view('tarif.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe_kendaraan' => 'required',
            'tarif_per_jam' => 'required|numeric',
        ]);

        Tarif::create([
            'tipe_kendaraan' => $request->tipe_kendaraan,
            'tarif_per_jam' => $request->tarif_per_jam,
            'created_by' => Auth::user()->name ?? 'system',
        ]);

        return redirect()->route('tarif.index');
    }

    public function edit(Tarif $tarif)
    {
        return view('tarif.edit', compact('tarif'));
    }

    public function update(Request $request, Tarif $tarif)
    {
        $tarif->update([
            'tipe_kendaraan' => $request->tipe_kendaraan,
            'tarif_per_jam' => $request->tarif_per_jam,
            'updated_by' => Auth::user()->name ?? 'system',
        ]);

        return redirect()->route('tarif.index');
    }

    public function destroy(Tarif $tarif)
    {
        $tarif->update([
            'deleted_by' => Auth::user()->name ?? 'system'
        ]);

        $tarif->delete();

        return redirect()->route('tarif.index');
    }
}
