<?php

namespace App\Http\Controllers;

use App\Models\MembershipTier;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class MembershipTierController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MembershipTier::select(
                'id', 'tier', 'harga', 'diskon', 'free_entry'
            );

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('harga', function ($row) {
                    return 'Rp ' . number_format($row->harga, 0, ',', '.');
                })
                ->addColumn('aksi', function ($row) {
                    return '
                        <div class="flex justify-center gap-2">
                            <a href="'.route('membership-tier.edit',$row->id).'"
                               class="text-blue-600 hover:underline text-sm">
                                Edit
                            </a>
                            <form action="'.route('membership-tier.destroy',$row->id).'" method="POST">
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

        return view('membership-tier.index');
    }

    public function create()
    {
        return view('membership-tier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tier'       => 'required|max:15',
            'harga'      => 'required|numeric',
            'diskon'     => 'required|integer',
            'free_entry' => 'required|integer',
        ]);

        MembershipTier::create([
            'tier'       => $request->tier,
            'harga'      => $request->harga,
            'diskon'     => $request->diskon,
            'free_entry' => $request->free_entry,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('membership-tier.index');
    }

    public function edit(MembershipTier $membership_tier)
    {
        return view('membership-tier.edit', [
            'membershipTier' => $membership_tier
        ]);
    }

    public function update(Request $request, MembershipTier $membership_tier)
    {
        $membership_tier->update([
            'tier'       => $request->tier,
            'harga'      => $request->harga,
            'diskon'     => $request->diskon,
            'free_entry' => $request->free_entry,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('membership-tier.index');
    }

    public function destroy(MembershipTier $membership_tier)
    {
        $membership_tier->update([
            'deleted_by' => Auth::id()
        ]);

        $membership_tier->delete();

        return redirect()->route('membership-tier.index');
    }
}
