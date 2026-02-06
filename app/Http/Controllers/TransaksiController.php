<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DataKendaraan;
use App\Models\TipeKendaraan;
use App\Models\AreaParkir;
use App\Models\AreaParkirDetail;
use App\Models\Tarif;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller {
    public function index() {
        $tipeKendaraan = TipeKendaraan::orderBy('tipe_kendaraan')->get();

        return view('transaksi.index', compact('tipeKendaraan'));
    }

    public function masuk(Request $request) {
        $request->validate([
            'plat_nomor' => 'required|string|max:20',
            'id_tipe_kendaraan' => 'required|exists:tb_tipe_kendaraan,id',
            'warna' => 'nullable|string|max:30',
            'pemilik' => 'nullable|string|max:100',
            'id_area' => 'required|exists:tb_area_parkir,id',
        ]);

        DB::beginTransaction();

        try {
            $kendaraan = DataKendaraan::where('plat_nomor', $request->plat_nomor)
                ->whereNull('deleted_at')
                ->first();

            if (!$kendaraan) {
                $kendaraan = DataKendaraan::create([
                    'id_tipe_kendaraan' => $request->id_tipe_kendaraan,
                    'plat_nomor'        => $request->plat_nomor,
                    'warna'             => $request->warna,
                    'pemilik'           => $request->pemilik,
                    'aktif'             => 1,
                    'created_by'        => Auth::id(),
                ]);
            }

            $cekTransaksi = Transaksi::where('id_data_kendaraan', $kendaraan->id)
                ->where('status', 'masuk')
                ->first();

            if ($cekTransaksi) {
                return back()->with('error', 'Kendaraan masih dalam status parkir.');
            }

            $detailArea = AreaParkirDetail::where('area_parkir_id', $request->id_area)
                ->where('id_tipe_kendaraan', $request->id_tipe_kendaraan)
                ->lockForUpdate()
                ->first();

            if (!$detailArea) {
                return back()->with('error', 'Area parkir atau tipe kendaraan tidak valid.');
            }

            $tipe = TipeKendaraan::findOrFail($request->id_tipe_kendaraan);
            $tersisa = min($tipe->kapasitas, $detailArea->kapasitas) - $detailArea->terisi;

            if ($tersisa <= 0) {
                return back()->with('error', 'Area parkir penuh untuk tipe kendaraan ini.');
            }

            $transaksi = Transaksi::create([
                'kode_tiket' => 'INV/' . $kendaraan->id . '/' . now()->format('YmdHis'),
                'id_data_kendaraan' => $kendaraan->id,
                'waktu_masuk' => now(),
                'status' => 'masuk',
                'id_area' => $request->id_area,
                'created_by' => Auth::id(),
            ]);
            $detailArea->increment('terisi', $tipe->kapasitas);

            DB::commit();

            return redirect()->route('transaksi.tiket-masuk', $transaksi->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function keluar(Request $request) {
        $request->validate([
            'plat_nomor' => 'required|string|max:20',
        ]);

        DB::beginTransaction();

        try {
            // 1️⃣ CARI KENDARAAN
            $kendaraan = DataKendaraan::where('plat_nomor', $request->plat_nomor)
                ->whereNull('deleted_at')
                ->firstOrFail();

            // 2️⃣ CARI TRANSAKSI MASUK
            $transaksi = Transaksi::where('id_data_kendaraan', $kendaraan->id)
                ->where('status', 'masuk')
                ->lockForUpdate()
                ->first();

            if (!$transaksi) {
                return back()->with('error', 'Kendaraan tidak sedang parkir.');
            }

            // 3️⃣ SET WAKTU KELUAR
            $waktuKeluar = now();
            $waktuMasuk  = $transaksi->waktu_masuk;

            // 4️⃣ HITUNG DURASI (MENIT → JAM)
            $durasiMenit = $waktuMasuk->diffInMinutes($waktuKeluar);
            $durasiJam   = max(1, ceil($durasiMenit / 60));

            // 5️⃣ AMBIL TARIF (BERDASARKAN TIPE)
            $tarif = Tarif::where('id_tipe_kendaraan', $kendaraan->id_tipe_kendaraan)
                ->firstOrFail();

            $biayaDasar = $durasiJam * $tarif->tarif_per_jam;

            // 6️⃣ DISKON (CONTOH MEMBER 15%)
            $diskonPersen = 15;
            $diskon = ($diskonPersen / 100) * $biayaDasar;

            $totalBayar = $biayaDasar - $diskon;

            // 7️⃣ UPDATE TRANSAKSI
            $transaksi->update([
                'waktu_keluar' => $waktuKeluar,
                'status'       => 'keluar',
                'id_tarif'     => $tarif->id,
                'durasi_jam'   => $durasiJam,
                'biaya'        => $biayaDasar,
                'biaya_total'  => $totalBayar,
                'id_user'      => Auth::id(),
            ]);

            // 8️⃣ KURANGI TERISI AREA (PAKAI KAPASITAS TIPE)
            $detailArea = AreaParkirDetail::where('area_parkir_id', $transaksi->id_area)
                ->where('id_tipe_kendaraan', $kendaraan->id_tipe_kendaraan)
                ->lockForUpdate()
                ->firstOrFail();

            $tipe = TipeKendaraan::findOrFail($kendaraan->id_tipe_kendaraan);

            // kendaraan keluar → slot dibalikin sesuai kapasitas tipe
            $detailArea->decrement('terisi', $tipe->kapasitas);

            DB::commit();

            return redirect()->route('transaksi.tiket-keluar', $transaksi->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function getAreaByTipe($tipeId)
    {
        $tipe = TipeKendaraan::findOrFail($tipeId);

        return AreaParkir::whereHas('details', function ($q) use ($tipeId) {
                $q->where('id_tipe_kendaraan', $tipeId);
            })
            ->with(['details' => function($q) use ($tipeId) {
                $q->where('id_tipe_kendaraan', $tipeId);
            }])
            ->get()
            ->map(function($area) use ($tipe) {
                $detail = $area->details->first();
                $tersisa = ($detail->kapasitas - $detail->terisi) / $tipe->kapasitas;

                return [
                    'id'        => $area->id,
                    'nama_area' => $area->nama_area,
                    'tersisa'   => $tersisa > 0 ? $tersisa : 0,
                ];
            });
    }

    public function tiketMasuk($id)
    {
        $transaksi = Transaksi::with([
            'dataKendaraan.tipeKendaraan',
            'areaParkir'
        ])->findOrFail($id);

        return view('transaksi.tiket-masuk', compact('transaksi'));
    }

    public function tiketKeluar($id)
    {
        $transaksi = Transaksi::with([
            'dataKendaraan.tipeKendaraan',
            'areaParkir',
            'user'
        ])->findOrFail($id);

        return view('transaksi.tiket-keluar', compact('transaksi'));
    }

    public function aktif(Request $request)
    {
        if ($request->ajax()) {
            $data = Transaksi::with(['dataKendaraan.tipeKendaraan', 'areaParkir'])
                ->where('status', 'masuk')
                ->select('tb_transaksi.*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('plat', fn($row) => $row->dataKendaraan->plat_nomor ?? '-')
                ->addColumn('tipe', fn($row) => $row->dataKendaraan->tipeKendaraan->tipe_kendaraan ?? '-')
                ->addColumn('area', fn($row) => $row->areaParkir->nama_area ?? '-')
                ->editColumn('waktu_masuk', fn($row) => $row->waktu_masuk->format('d-m-Y H:i'))

                ->orderColumn('plat', function ($query, $order) {
                    $query->join('tb_data_kendaraan as dk', 'dk.id', '=', 'tb_transaksi.id_data_kendaraan')
                        ->orderBy('dk.plat_nomor', $order);
                })
                ->orderColumn('tipe', function ($query, $order) {
                    $query->join('tb_data_kendaraan as dk2', 'dk2.id', '=', 'tb_transaksi.id_data_kendaraan')
                        ->join('tb_tipe_kendaraan as tk', 'tk.id', '=', 'dk2.id_tipe_kendaraan')
                        ->orderBy('tk.tipe_kendaraan', $order);
                })
                ->orderColumn('area', function ($query, $order) {
                    $query->join('tb_area_parkir as ap', 'ap.id', '=', 'tb_transaksi.id_area')
                        ->orderBy('ap.nama_area', $order);
                })
                ->orderColumn('waktu_masuk', fn ($q, $o) =>
                    $q->orderBy('waktu_masuk', $o)
                )

                ->filterColumn('plat', function ($query, $keyword) {
                    $query->whereExists(function ($sub) use ($keyword) {
                        $sub->select(DB::raw(1))
                            ->from('tb_data_kendaraan')
                            ->whereColumn('tb_data_kendaraan.id', 'tb_transaksi.id_data_kendaraan')
                            ->where('tb_data_kendaraan.plat_nomor', 'LIKE', "%{$keyword}%");
                    });
                })
                ->filterColumn('tipe', function ($query, $keyword) {
                    $query->whereExists(function ($sub) use ($keyword) {
                        $sub->select(DB::raw(1))
                            ->from('tb_data_kendaraan')
                            ->join(
                                'tb_tipe_kendaraan',
                                'tb_tipe_kendaraan.id',
                                '=',
                                'tb_data_kendaraan.id_tipe_kendaraan'
                            )
                            ->whereColumn('tb_data_kendaraan.id', 'tb_transaksi.id_data_kendaraan')
                            ->where('tb_tipe_kendaraan.tipe_kendaraan', 'LIKE', "%{$keyword}%");
                    });
                })
                ->filterColumn('area', function ($query, $keyword) {
                    $query->whereExists(function ($sub) use ($keyword) {
                        $sub->select(DB::raw(1))
                            ->from('tb_area_parkir')
                            ->whereColumn('tb_area_parkir.id', 'tb_transaksi.id_area')
                            ->where('tb_area_parkir.nama_area', 'LIKE', "%{$keyword}%");
                    });
                })
                    ->addColumn('status_badge', function ($row) {
                    return '<span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                        MASUK
                    </span>';
                })
                ->rawColumns(['status_badge'])
                ->make(true);
        }

        return view('transaksi.aktif');
    }

    public function riwayat(Request $request)
    {
        if ($request->ajax()) {
            $data = Transaksi::with(['dataKendaraan.tipeKendaraan', 'areaParkir'])
                ->where('status', 'keluar')
                ->select('tb_transaksi.*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('plat', fn($row) => $row->dataKendaraan->plat_nomor ?? '-')
                ->addColumn('tipe', fn($row) => $row->dataKendaraan->tipeKendaraan->tipe_kendaraan ?? '-')
                ->addColumn('durasi', fn($row) => $row->durasi_jam . ' jam')
                ->editColumn('biaya_total', fn($row) => 'Rp ' . number_format($row->biaya_total, 0, ',', '.'))
                ->orderColumn('plat', function ($query, $order) {
                    $query->join('tb_data_kendaraan as dk', 'dk.id', '=', 'tb_transaksi.id_data_kendaraan')
                        ->orderBy('dk.plat_nomor', $order);
                })
                ->orderColumn('tipe', function ($query, $order) {
                    $query->join('tb_data_kendaraan as dk2', 'dk2.id', '=', 'tb_transaksi.id_data_kendaraan')
                        ->join('tb_tipe_kendaraan as tk', 'tk.id', '=', 'dk2.id_tipe_kendaraan')
                        ->orderBy('tk.tipe_kendaraan', $order);
                })
                ->orderColumn('durasi', fn($q, $o) => $q->orderBy('durasi_jam', $o))
                ->orderColumn('biaya_total', fn($q, $o) => $q->orderBy('biaya_total', $o))
                    ->filterColumn('plat', function ($query, $keyword) {
                        $query->whereExists(function ($sub) use ($keyword) {
                            $sub->select(DB::raw(1))
                                ->from('tb_data_kendaraan')
                                ->whereColumn('tb_data_kendaraan.id', 'tb_transaksi.id_data_kendaraan')
                                ->where('tb_data_kendaraan.plat_nomor', 'LIKE', "%{$keyword}%");
                        });
                    })

                    ->filterColumn('tipe', function ($query, $keyword) {
                        $query->whereExists(function ($sub) use ($keyword) {
                            $sub->select(DB::raw(1))
                                ->from('tb_data_kendaraan')
                                ->join('tb_tipe_kendaraan', 'tb_tipe_kendaraan.id', '=', 'tb_data_kendaraan.id_tipe_kendaraan')
                                ->whereColumn('tb_data_kendaraan.id', 'tb_transaksi.id_data_kendaraan')
                                ->where('tb_tipe_kendaraan.tipe_kendaraan', 'LIKE', "%{$keyword}%");
                        });
                    })
                    ->filterColumn('durasi', function ($query, $keyword) {
                        $angka = preg_replace('/[^0-9]/', '', $keyword);

                        if ($angka !== '') {
                            $query->where('durasi_jam', $angka);
                        }
                    })
                ->addColumn('aksi', function ($row) {
                    return '
                        <a href="'.route('transaksi.struk', $row->id).'"
                        class="text-blue-600 hover:underline text-sm">
                            Detail
                        </a>
                    ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('transaksi.riwayat');
    }

    public function struk($id)
    {
        $transaksi = Transaksi::with([
            'dataKendaraan.tipeKendaraan',
            'areaParkir',
            'tarif'
        ])->findOrFail($id);

        return view('transaksi.struk', compact('transaksi'));
    }
}
