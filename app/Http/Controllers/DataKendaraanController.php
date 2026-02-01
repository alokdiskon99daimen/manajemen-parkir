<?php

namespace App\Http\Controllers;

use App\Models\DataKendaraan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class DataKendaraanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DataKendaraan::select(
                'id',
                'tipe_kendaraan',
                'plat_nomor',
                'warna',
                'pemilik',
                'aktif'
            );

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aktif', function ($row) {
                    return $row->aktif
                        ? '<span class="px-2 py-1 text-xs bg-green-500 text-green-700 rounded">Aktif</span>'
                        : '<span class="px-2 py-1 text-xs bg-red-500 text-red-700 rounded">Nonaktif</span>';
                })
                ->addColumn('aksi', function ($row) {
                    return '
                        <div class="flex justify-center gap-2">
                            <a href="'.route('data-kendaraan.edit',$row->id).'"
                               class="text-blue-600 hover:underline text-sm">
                                Edit
                            </a>
                            <form action="'.route('data-kendaraan.destroy',$row->id).'" method="POST">
                                '.csrf_field().method_field('DELETE').'
                                <button class="text-red-600 hover:underline text-sm"
                                        onclick="return confirm(\'Yakin?\')">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['aktif','aksi'])
                ->make(true);
        }

        return view('data-kendaraan.index');
    }

    public function create()
    {
        return view('data-kendaraan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe_kendaraan' => 'required',
            'plat_nomor'     => 'required|unique:tb_data_kendaraan',
            'warna'          => 'required',
            'pemilik'        => 'required',
        ]);

        DataKendaraan::create([
            'tipe_kendaraan' => $request->tipe_kendaraan,
            'plat_nomor'     => $request->plat_nomor,
            'warna'          => $request->warna,
            'pemilik'        => $request->pemilik,
            'aktif'          => $request->aktif ?? 1,
            'created_by'     => Auth::user()->name ?? 'system',
        ]);

        return redirect()->route('data-kendaraan.index');
    }

    public function edit(DataKendaraan $dataKendaraan)
    {
        return view('data-kendaraan.edit', compact('dataKendaraan'));
    }

    public function update(Request $request, DataKendaraan $dataKendaraan)
    {
        $request->validate([
            'tipe_kendaraan' => 'required',
            'plat_nomor'     => 'required|unique:tb_data_kendaraan,plat_nomor,'.$dataKendaraan->id,
            'warna'          => 'required',
            'pemilik'        => 'required',
        ]);

        $dataKendaraan->update([
            'tipe_kendaraan' => $request->tipe_kendaraan,
            'plat_nomor'     => $request->plat_nomor,
            'warna'          => $request->warna,
            'pemilik'        => $request->pemilik,
            'aktif'          => $request->aktif,
            'updated_by'     => Auth::user()->name ?? 'system',
        ]);

        return redirect()->route('data-kendaraan.index');
    }

    public function destroy(DataKendaraan $dataKendaraan)
    {
        $dataKendaraan->update([
            'deleted_by' => Auth::user()->name ?? 'system'
        ]);

        $dataKendaraan->delete();

        return redirect()->route('data-kendaraan.index');
    }
}