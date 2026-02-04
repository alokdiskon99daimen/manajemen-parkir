<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DataKendaraan;
use App\Models\TipeKendaraan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $tipeKendaraan = TipeKendaraan::orderBy('tipe_kendaraan')->get();

        return view('transaksi.index', compact('tipeKendaraan'));
    }

    public function masuk(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required|string|max:20',
            'tipe_kendaraan' => 'nullable|string|max:50',
            'warna' => 'nullable|string|max:30',
            'pemilik' => 'nullable|string|max:100',
        ]);

        DB::beginTransaction();

        try {
            /**
             * 1️⃣ CEK DATA KENDARAAN
             */
            $kendaraan = DataKendaraan::where('plat_nomor', $request->plat_nomor)
                ->whereNull('deleted_at')
                ->first();

            /**
             * 2️⃣ JIKA BELUM ADA → BUAT BARU
             */
            if (!$kendaraan) {
                $kendaraan = DataKendaraan::create([
                    'tipe_kendaraan' => $request->tipe_kendaraan,
                    'plat_nomor'     => $request->plat_nomor,
                    'warna'          => $request->warna,
                    'pemilik'        => $request->pemilik,
                    'aktif'          => 1,
                    'created_by'     => Auth::id(),
                ]);
            }

            /**
             * 3️⃣ CEK APAKAH MASIH ADA TRANSAKSI MASUK (ANTI DOUBLE PARKIR)
             */
            $cekTransaksi = Transaksi::where('id_data_kendaraan', $kendaraan->id)
                ->where('status', 'masuk')
                ->first();

            if ($cekTransaksi) {
                return back()->with('error', 'Kendaraan masih dalam status parkir.');
            }

            /**
             * 4️⃣ BUAT TRANSAKSI MASUK
             */
            Transaksi::create([
                'kode_tiket' => 'INV/' . $kendaraan->id . '/' . now()->format('YmdHis'),
                'id_data_kendaraan' => $kendaraan->id,
                'waktu_masuk' => now(),
                'status' => 'masuk',
                'id_area' => 1, // sementara (nanti bisa dari dropdown / user)
                'created_by' => Auth::id(),
            ]);

            DB::commit();

            return back()->with('success', 'Tiket masuk berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
