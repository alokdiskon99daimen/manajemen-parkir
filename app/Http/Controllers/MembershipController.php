<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\DataKendaraan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MembershipController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Membership::with('tier')
                ->select(
                    'id',
                    'nama_lengkap',
                    'membership_tier_id',
                    'loyalty_point',
                    'expired',
                    'free_entry_quota as free_entry',
                    'aktif',
                );

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tier', function ($row) {
                    return $row->tier->tier ?? '-';
                })
            ->editColumn('expired', function ($row) {
                return $row->expired
                    ? $row->expired->format('d-m-Y H:i') : '-';
            })
                ->editColumn('aktif', function ($row) {
                    return $row->aktif
                        ? '<span class="px-2 py-1 text-xs bg-green-500 rounded">Aktif</span>'
                        : '<span class="px-2 py-1 text-xs bg-red-500 rounded">Nonaktif</span>';
                })
                ->addColumn('aksi', function ($row) {
                    return '
                        <div class="flex justify-center gap-2">
                            <button
                                onclick="openKendaraanModal('.$row->id.')"
                                class="text-purple-600 hover:underline text-sm">
                                Kendaraan
                            </button>
                            <button
                                onclick="openRedeemModal('.$row->id.', '.$row->loyalty_point.')"
                                class="text-green-600 hover:underline text-sm">
                                Tukar
                            </button>
                            <a href="'.route('membership.edit',$row->id).'"
                            class="text-blue-600 hover:underline text-sm">
                                Edit
                            </a>
                            <form action="'.route('membership.destroy',$row->id).'" method="POST">
                                '.csrf_field().method_field('DELETE').'
                                <button class="text-red-600 hover:underline text-sm"
                                        onclick="return confirm(\'YYakin ingin menghapus data ini??\')">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['aktif','aksi'])
                ->make(true);
        }

        return view('membership.index');
    }

    public function create()
    {
        $tiers = MembershipTier::select('id', 'tier')->get();
        return view('membership.create', compact('tiers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'        => 'required',
            'membership_tier_id'  => 'required|integer',
            'loyalty_point'       => 'required|integer',
            'expired'             => 'required|date',
            'kendaraan'           => 'array', // id_data_kendaraan[]
        ]);

        DB::transaction(function () use ($request) {

            $membership = Membership::create([
                'nama_lengkap'       => $request->nama_lengkap,
                'membership_tier_id' => $request->membership_tier_id,
                'loyalty_point'      => $request->loyalty_point,
                'last_renewal'       => now(),
                'expired'            => $request->expired,
                'aktif'              => $request->has('aktif') ? 1 : 0,
                'created_by'         => Auth::id(),
            ]);

            // simpan kendaraan ke tb_membership_kendaraan
            if ($request->kendaraan) {
                $membership->kendaraan()->sync($request->kendaraan);
            }
        });

        return redirect()->route('membership.index');
    }

    public function edit(Membership $membership)
    {
        $tiers = MembershipTier::select('id', 'tier')->get();

        // ambil kendaraan yang sudah terhubung
        $membership->load('kendaraan:id,plat_nomor');

        return view('membership.edit', compact('membership', 'tiers'));
    }

    public function update(Request $request, Membership $membership)
    {
        $membership->update([
            'nama_lengkap'       => $request->nama_lengkap,
            'membership_tier_id' => $request->membership_tier_id,
            'loyalty_point'      => $request->loyalty_point,
            'expired'            => $request->expired,
            'aktif'              => $request->has('aktif'),
            'updated_by'         => Auth::id(),
        ]);

        // sync kendaraan (inti 1 membership banyak kendaraan)
        if ($request->kendaraan) {
            $membership->kendaraan()->sync($request->kendaraan);
        } else {
            $membership->kendaraan()->detach();
        }

        return redirect()
            ->route('membership.index')
            ->with('success', 'Membership berhasil diperbarui');
    }

    public function destroy(Membership $membership)
    {
        $membership->update([
            'deleted_by' => Auth::id()
        ]);

        $membership->delete();

        return redirect()->route('membership.index');
    }

    public function searchKendaraan(Request $request)
    {
        $data = DataKendaraan::where('plat_nomor', 'like', '%' . $request->q . '%')
            ->limit(10)
            ->get();

        return response()->json(
            $data->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->plat_nomor
                ];
            })
        );
    }

    public function redeemPoint(Request $request, Membership $membership)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        // 🔧 aturan penukaran
        $POINT_PER_ENTRY = 10; // 10 point = 1 free entry

        $qty        = (int) $request->qty;
        $needPoint = $qty * $POINT_PER_ENTRY;

        // refresh biar ambil data terbaru
        $membership->refresh();

        if ($membership->loyalty_point < $needPoint) {
            return response()->json([
                'message' => 'Loyalty point tidak mencukupi'
            ], 422);
        }

        DB::transaction(function () use ($membership, $needPoint, $qty) {
            // kurangi point
            $membership->loyalty_point -= $needPoint;

            // tambah free entry
            $membership->free_entry_quota += $qty;

            $membership->updated_by = auth()->id();
            $membership->save();
        });

        return response()->json([
            'message' => 'Berhasil menukar loyalty point',
            'data' => [
                'loyalty_point' => $membership->loyalty_point,
                'free_entry'    => $membership->free_entry_quota,
            ]
        ]);
    }

    public function kendaraanDatatable(Membership $membership, Request $request)
    {
        $data = $membership->kendaraan()
            ->join(
                'tb_tipe_kendaraan',
                'tb_tipe_kendaraan.id',
                '=',
                'tb_data_kendaraan.id_tipe_kendaraan'
            )
            ->select([
                'tb_data_kendaraan.id',
                'tb_data_kendaraan.plat_nomor',
                'tb_tipe_kendaraan.tipe_kendaraan',
                'tb_data_kendaraan.warna',
                'tb_data_kendaraan.pemilik',
            ]);

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
