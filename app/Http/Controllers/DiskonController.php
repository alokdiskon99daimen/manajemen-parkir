<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class DiskonController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Diskon::select(
                'id',
                'nama_diskon',
                'diskon',
                'waktu_mulai',
                'waktu_selesai'
            );

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('diskon', function ($row) {
                    return $row->diskon . ' %';
                })
                ->editColumn('waktu_mulai', function ($row) {
                    return $row->waktu_mulai
                        ? date('Y-m-d', strtotime($row->waktu_mulai))
                        : '-';
                })
                ->editColumn('waktu_selesai', function ($row) {
                    return $row->waktu_selesai
                        ? date('Y-m-d', strtotime($row->waktu_selesai))
                        : '-';
                })
                ->addColumn('aksi', function ($row) {
                    return '
                        <div class="flex justify-center gap-2">
                            <a href="'.route('diskon.edit',$row->id).'"
                               class="text-blue-600 hover:underline text-sm">
                                Edit
                            </a>
                            <form action="'.route('diskon.destroy',$row->id).'" method="POST">
                                '.csrf_field().method_field('DELETE').'
                                <button class="text-red-600 hover:underline text-sm"
                                        onclick="return confirm(\'Yakin hapus diskon?\')">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('diskon.index');
    }

    public function create()
    {
        return view('diskon.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_diskon'   => 'required|max:50',
            'diskon'        => 'required|integer|min:0|max:100',
            'waktu_mulai'   => 'nullable|date',
            'waktu_selesai' => 'nullable|date|after:waktu_mulai',
        ]);

        Diskon::create([
            'nama_diskon'   => $request->nama_diskon,
            'diskon'        => $request->diskon,
            'waktu_mulai'   => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'created_by'    => Auth::id(),
        ]);

        return redirect()->route('diskon.index');
    }

    public function edit(Diskon $diskon)
    {
        return view('diskon.edit', compact('diskon'));
    }

    public function update(Request $request, Diskon $diskon)
    {
        $request->validate([
            'nama_diskon'   => 'required|max:50',
            'diskon'        => 'required|integer|min:0|max:100',
            'waktu_mulai'   => 'nullable|date',
            'waktu_selesai' => 'nullable|date|after:waktu_mulai',
        ]);

        $diskon->update([
            'nama_diskon'   => $request->nama_diskon,
            'diskon'        => $request->diskon,
            'waktu_mulai'   => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'updated_by'    => Auth::id(),
        ]);

        return redirect()->route('diskon.index');
    }

    public function destroy(Diskon $diskon)
    {
        $diskon->update([
            'deleted_by' => Auth::id()
        ]);

        $diskon->delete();

        return redirect()->route('diskon.index');
    }
}
