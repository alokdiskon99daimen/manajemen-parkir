<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\MembershipTier;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

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
                    'aktif'
                );

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tier', function ($row) {
                    return $row->tier->tier ?? '-';
                })
                ->editColumn('aktif', function ($row) {
                    return $row->aktif
                        ? '<span class="px-2 py-1 text-xs bg-green-500 text-green-700 rounded">Aktif</span>'
                        : '<span class="px-2 py-1 text-xs bg-red-500 text-red-700 rounded">Nonaktif</span>';
                })
                ->addColumn('aksi', function ($row) {
                    return '
                        <div class="flex justify-center gap-2">
                            <a href="'.route('membership.edit',$row->id).'"
                            class="text-blue-600 hover:underline text-sm">
                                Edit
                            </a>
                            <form action="'.route('membership.destroy',$row->id).'" method="POST">
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
        ]);

        Membership::create([
            'nama_lengkap'       => $request->nama_lengkap,
            'membership_tier_id' => $request->membership_tier_id,
            'loyalty_point'      => $request->loyalty_point,
            'last_renewal'       => now(),
            'expired'            => $request->expired,
            'aktif'              => $request->has('aktif') ? 1 : 0,
            'created_by'         => Auth::id(),
        ]);

        return redirect()->route('membership.index');
    }

    public function edit(Membership $membership)
    {
        $tiers = MembershipTier::select('id', 'tier')->get();
        return view('membership.edit', compact('membership', 'tiers'));
    }

    public function update(Request $request, Membership $membership)
    {
        $membership->update([
            'nama_lengkap'       => $request->nama_lengkap,
            'membership_tier_id' => $request->membership_tier_id,
            'loyalty_point'      => $request->loyalty_point,
            'expired'            => $request->expired,
            'aktif'              => $request->aktif,
            'updated_by'         => Auth::id(),
        ]);

        return redirect()->route('membership.index');
    }

    public function destroy(Membership $membership)
    {
        $membership->update([
            'deleted_by' => Auth::id()
        ]);

        $membership->delete();

        return redirect()->route('membership.index');
    }
}
