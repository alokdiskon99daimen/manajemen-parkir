<?php

namespace App\Http\Controllers;

use App\Models\TipeKendaraan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class TipeKendaraanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TipeKendaraan::select('id', 'tipe_kendaraan');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    return '
                        <div class="flex justify-center gap-2">
                            <a href="'.route('tipe-kendaraan.edit',$row->id).'"
                               class="text-blue-600 hover:underline text-sm">
                               Edit
                            </a>
                            <form action="'.route('tipe-kendaraan.destroy',$row->id).'" method="POST">
                                '.csrf_field().method_field('DELETE').'
                                <button class="text-red-600 hover:underline text-sm"
                                        onclick="return confirm(\'YYakin ingin menghapus data ini??\')">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('tipe-kendaraan.index');
    }

    public function create()
    {
        return view('tipe-kendaraan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe_kendaraan' => 'required',
        ]);

        TipeKendaraan::create([
            'tipe_kendaraan' => $request->tipe_kendaraan,
            'kapasitas' => 1,
            'created_by' => Auth::user()->name ?? 'system',
        ]);

        return redirect()->route('tipe-kendaraan.index');
    }

    public function edit(TipeKendaraan $tipeKendaraan)
    {
        return view('tipe-kendaraan.edit', compact('tipeKendaraan'));
    }

    public function update(Request $request, TipeKendaraan $tipeKendaraan)
    {
        $tipeKendaraan->update([
            'tipe_kendaraan' => $request->tipe_kendaraan,
            'kapasitas' => 1,
            'updated_by' => Auth::user()->name ?? 'system',
        ]);

        return redirect()->route('tipe-kendaraan.index');
    }

    public function destroy(TipeKendaraan $tipeKendaraan)
    {
        $tipeKendaraan->update([
            'deleted_by' => Auth::user()->name ?? 'system'
        ]);

        $tipeKendaraan->delete();

        return redirect()->route('tipe-kendaraan.index');
    }
}
