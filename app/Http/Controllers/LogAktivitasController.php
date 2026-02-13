<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LogAktivitas::with('user')
                ->select('tb_log_aktivitas.id', 'id_user', 'method', 'activity', 'ip', 'user_agent', 'before', 'after', 'tb_log_aktivitas.created_at')
                ->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d-m-Y H:i');
                })
                ->addColumn('user', function ($row) {
                    return $row->user->name ?? '-';
                })
                ->make(true);
        }

        return view('log-aktivitas.index');
    }
}