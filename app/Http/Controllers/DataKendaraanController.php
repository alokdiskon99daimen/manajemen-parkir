<?php

namespace App\Http\Controllers;

use App\Models\DataKendaraan;
use App\Models\TipeKendaraan;
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
                'id_tipe_kendaraan',
                'plat_nomor',
                'warna',
                'pemilik',
                'aktif'
            );

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tipe_kendaraan', function ($row) {
                    return $row->tipeKendaraan->tipe_kendaraan ?? '-';
                })
                ->addColumn('aktif', function ($row) {
                    return $row->aktif
                        ? '<span class="px-2 py-1 text-xs bg-green-500 rounded">Aktif</span>'
                        : '<span class="px-2 py-1 text-xs bg-red-500 rounded">Nonaktif</span>';
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
        $tipeKendaraan = TipeKendaraan::orderBy('tipe_kendaraan')->get();
        return view('data-kendaraan.create', compact('tipeKendaraan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_tipe_kendaraan' => 'required|exists:tb_tipe_kendaraan,id',
            'plat_nomor'        => 'required|unique:tb_data_kendaraan,plat_nomor',
            'warna'             => 'required',
            'pemilik'           => 'required',
        ]);

        DataKendaraan::create([
            'id_tipe_kendaraan' => $request->id_tipe_kendaraan,
            'plat_nomor'        => strtoupper($request->plat_nomor),
            'warna'             => $request->warna,
            'pemilik'           => $request->pemilik,
            'aktif'             => $request->has('aktif'),
            'created_by'        => Auth::id(),
        ]);

        return redirect()->route('data-kendaraan.index')
            ->with('success', 'Data kendaraan berhasil ditambahkan');
    }

    public function edit(DataKendaraan $dataKendaraan)
    {
        $tipeKendaraan = TipeKendaraan::orderBy('tipe_kendaraan')->get();
        return view('data-kendaraan.edit', compact('dataKendaraan','tipeKendaraan'));
    }

    public function update(Request $request, DataKendaraan $dataKendaraan)
    {
        $request->validate([
            'id_tipe_kendaraan' => 'required|exists:tb_tipe_kendaraan,id',
            'plat_nomor'        => 'required|unique:tb_data_kendaraan,plat_nomor,' . $dataKendaraan->id,
            'warna'             => 'required',
            'pemilik'           => 'required',
        ]);

        $dataKendaraan->update([
            'id_tipe_kendaraan' => $request->id_tipe_kendaraan,
            'plat_nomor'        => strtoupper($request->plat_nomor),
            'warna'             => $request->warna,
            'pemilik'           => $request->pemilik,
            'aktif'             => $request->has('aktif'),
            'updated_by'        => Auth::id(),
        ]);

        return redirect()->route('data-kendaraan.index')
            ->with('success', 'Data kendaraan berhasil diperbarui');
    }

    public function destroy(DataKendaraan $dataKendaraan)
    {
        $dataKendaraan->update([
            'deleted_by' => Auth::user()->name ?? 'system'
        ]);

        $dataKendaraan->delete();

        return redirect()->route('data-kendaraan.index');
    }

    public function search(Request $request)
    {
        return DataKendaraan::with('tipeKendaraan')
            ->where('plat_nomor', 'like', '%' . $request->q . '%')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'plat_nomor' => $item->plat_nomor,
                    'id_tipe_kendaraan' => $item->id_tipe_kendaraan,
                    'warna' => $item->warna,
                    'pemilik' => $item->pemilik,
                ];
            });
    }
}