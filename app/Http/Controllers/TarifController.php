<?php

namespace App\Http\Controllers;

use App\Models\Tarif;
use App\Models\TipeKendaraan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class TarifController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Tarif::with('tipeKendaraan')
                ->select('tb_tarif.id', 'id_tipe_kendaraan', 'durasi_mulai', 'tarif_per_jam');

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('tipe_kendaraan', function ($row) {
                    return $row->tipeKendaraan->tipe_kendaraan ?? '-';
                })
                ->filterColumn('tipe_kendaraan', function ($query, $keyword) {
                    $query->whereHas('tipeKendaraan', function ($q) use ($keyword) {
                        $q->where('tipe_kendaraan', 'like', "%{$keyword}%");
                    });
                })
                ->orderColumn('tipe_kendaraan', function ($query, $order) {
                    $query->join('tb_tipe_kendaraan', 'tb_tarif.id_tipe_kendaraan', '=', 'tb_tipe_kendaraan.id')
                        ->orderBy('tb_tipe_kendaraan.tipe_kendaraan', $order);
                })

                ->editColumn('durasi_mulai', function ($row) {
                    return $row->durasi_mulai . ' jam';
                })

                ->editColumn('tarif_per_jam', function ($row) {
                    return 'Rp ' . number_format($row->tarif_per_jam, 0, ',', '.');
                })

                ->addColumn('aksi', function ($row) {
                    return '
                        <div class="flex justify-center gap-2">
                            <a href="'.route('tarif.edit',$row->id).'" class="text-blue-600 hover:underline text-sm">
                                Edit
                            </a>
                            <form action="'.route('tarif.destroy',$row->id).'" method="POST">
                                '.csrf_field().method_field('DELETE').'
                                <button class="text-red-600 hover:underline text-sm"
                                        onclick="return confirm(\'Yakin ingin menghapus data ini??\')">
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
        $tipeKendaraan = TipeKendaraan::all();
        return view('tarif.create', compact('tipeKendaraan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_tipe_kendaraan' => 'required|exists:tb_tipe_kendaraan,id',
            'durasi_mulai' => 'required|numeric|min:0',
            'tarif_per_jam' => 'required|numeric',
        ]);

        $exists = Tarif::where('id_tipe_kendaraan', $request->id_tipe_kendaraan)
                        ->where('durasi_mulai', $request->durasi_mulai)
                        ->first();

        if ($exists) {
            return back()->withInput()->with('error', 'Tarif dengan tipe kendaraan dan durasi mulai ini sudah ada.');
        }

        Tarif::create([
            'id_tipe_kendaraan' => $request->id_tipe_kendaraan,
            'durasi_mulai' => $request->durasi_mulai,
            'tarif_per_jam' => $request->tarif_per_jam,
            'created_by' => Auth::user()->name ?? 'system',
        ]);

        return redirect()->route('tarif.index')->with('success', 'Data tarif berhasil ditambahkan.');
    }

    public function edit(Tarif $tarif)
    {
        $tipeKendaraan = TipeKendaraan::all();
        return view('tarif.edit', compact('tarif', 'tipeKendaraan'));
    }

    public function update(Request $request, Tarif $tarif)
    {
        $request->validate([
            'id_tipe_kendaraan' => 'required|exists:tb_tipe_kendaraan,id',
            'durasi_mulai' => 'required|numeric|min:0',
            'tarif_per_jam' => 'required|numeric',
        ]);

        $exists = Tarif::where('id_tipe_kendaraan', $request->id_tipe_kendaraan)
                        ->where('durasi_mulai', $request->durasi_mulai)
                        ->where('id', '!=', $tarif->id)
                        ->first();

        if ($exists) {
            return back()->withInput()->with('error', 'Tarif dengan tipe kendaraan dan durasi mulai ini sudah ada.');
        }

        $tarif->update([
            'id_tipe_kendaraan' => $request->id_tipe_kendaraan,
            'durasi_mulai' => $request->durasi_mulai,
            'tarif_per_jam' => $request->tarif_per_jam,
            'updated_by' => Auth::user()->name ?? 'system',
        ]);

        return redirect()->route('tarif.index')->with('success', 'Data tarif berhasil diupdate.');
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
