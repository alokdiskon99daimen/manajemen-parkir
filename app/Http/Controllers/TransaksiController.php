<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DataKendaraan;
use App\Models\TipeKendaraan;
use App\Models\AreaParkir;
use App\Models\AreaParkirDetail;
use App\Models\Tarif;
use App\Models\MetodePembayaran;
use App\Models\Membership;
use App\Models\MembershipKendaraan;
use App\Models\MembershipTier;
use App\Models\Diskon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\LogActivityHelper;


class TransaksiController extends Controller {
    public function index() {
        $tipeKendaraan = TipeKendaraan::orderBy('tipe_kendaraan')->get();
        $metodePembayaran = MetodePembayaran::orderBy('metode_pembayaran')->get();
        $diskon = Diskon::where('waktu_mulai', '<=', now())
            ->where('waktu_selesai', '>=', now())
            ->whereNull('deleted_at')
            ->orderByDesc('diskon')
            ->get();

        return view('transaksi.index', compact('tipeKendaraan', 'metodePembayaran', 'diskon'));
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
            $tersisa = $detailArea->kapasitas - $detailArea->terisi;

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

            LogActivityHelper::log(
                "[TRANSAKSI MASUK] Kode: {$transaksi->kode_tiket} | "
                ."Plat: {$kendaraan->plat_nomor} | "
                ."Tipe: {$tipe->tipe_kendaraan} | "
            );

            return redirect()->route('transaksi.tiket-masuk', $transaksi->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function keluar(Request $request) {
        $request->validate([
            'plat_nomor' => 'required|string|max:20',
            'id_metode_pembayaran' => 'required|exists:tb_metode_pembayaran,id',
            'diskon' => 'nullable|exists:tb_diskon,id',
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

            // 3️⃣ WAKTU
            $waktuKeluar = now();
            $waktuMasuk  = $transaksi->waktu_masuk;

            // 4️⃣ DURASI
            $durasiMenit = $waktuMasuk->diffInMinutes($waktuKeluar);
            $durasiJam   = max(1, ceil($durasiMenit / 60));

            // 5️⃣ TARIF (iteratif per jam sesuai durasi_mulai)
            $tarifs = Tarif::where('id_tipe_kendaraan', $kendaraan->id_tipe_kendaraan)
                ->orderBy('durasi_mulai', 'asc')
                ->get();

            if ($tarifs->isEmpty()) {
                return back()->with('error', 'Belum ada tarif untuk tipe kendaraan ini.');
            }

            $biayaDasar = 0;

            // iterasi per jam dari 1 sampai durasiJam
            for ($i = 1; $i <= $durasiJam; $i++) {
                // ambil tarif terbesar yang durasi_mulai <= jam ke-i
                $tarifUntukJam = $tarifs->where('durasi_mulai', '<=', $i)->last();
                $biayaDasar += $tarifUntukJam->tarif_per_jam;
            }

            // simpan tarif terakhir yang dipakai untuk catatan transaksi
            $tarif = $tarifUntukJam;

            // =========================
            // 6️⃣ DISKON
            // =========================
            $diskonMemberPersen = 0;
            $diskonManualPersen = 0;
            $isFreeEntry = false;
            $memberInfo = null;

            // 🔹 MEMBERSHIP
            $membershipKendaraan = MembershipKendaraan::where(
                'id_data_kendaraan',
                $kendaraan->id
            )->first();

            if ($membershipKendaraan) {
                $membership = Membership::find($membershipKendaraan->id_membership);

                if ($membership && $membership->aktif && $membership->expired->isFuture()) {

                    $memberInfo = [
                        'sisa_free_entry' => $membership->free_entry_quota,
                        'is_free_entry' => false,
                    ];

                    // 🆓 FREE ENTRY
                    if ($membership->free_entry_quota > 0) {
                        $isFreeEntry = true;
                        $membership->decrement('free_entry_quota', 1);

                        $memberInfo['is_free_entry'] = true;

                        LogActivityHelper::log(
                            "[FREE ENTRY] Plat: {$kendaraan->plat_nomor} | "
                            ."Sisa Kuota: {$membership->free_entry_quota}"
                        );
                    }
                    // 💸 DISKON TIER
                    else if ($membership->membership_tier_id) {
                        $tier = MembershipTier::find($membership->membership_tier_id);
                        if ($tier && $tier->diskon > 0) {
                            $diskonMemberPersen = $tier->diskon;
                        }
                    }
                }
            }

            // 🔹 DISKON MANUAL (DROPDOWN)
            if ($request->diskon) {
                $diskonData = Diskon::find($request->diskon);
                if ($diskonData) {
                    $diskonManualPersen = $diskonData->diskon;
                }
            }

            // =========================
            // 7️⃣ HITUNG TOTAL
            // =========================
            if ($isFreeEntry) {
                $diskonPersenTotal = 100;
                $diskonTotal = $biayaDasar;
                $totalBayar = 0;
            } else {
                // 👉 DIGABUNG
                $diskonPersenTotal = $diskonMemberPersen + $diskonManualPersen;
                $diskonPersenTotal = min($diskonPersenTotal, 100);

                $diskonTotal = ($diskonPersenTotal / 100) * $biayaDasar;
                $totalBayar = max(0, $biayaDasar - $diskonTotal);
            }

            // =========================
            // 8️⃣ UPDATE TRANSAKSI
            // =========================
            $transaksi->update([
                'waktu_keluar' => $waktuKeluar,
                'status'       => 'keluar',
                'id_tarif'     => $tarif->id,
                'id_metode_pembayaran' => $request->id_metode_pembayaran,
                'durasi_jam'   => $durasiJam,
                'biaya'        => $biayaDasar,
                'diskon_member'=> $diskonMemberPersen,
                'diskon_manual' => $diskonManualPersen,
                'biaya_total'  => $totalBayar,
                'id_user'      => Auth::id(),
            ]);

            // =========================
            // 9️⃣ LOYALTY POINT
            // =========================
            if (!$isFreeEntry && isset($membership) && $membership->aktif && $membership->expired->isFuture()) {
                $point = floor($totalBayar / 1000);
                if ($point > 0) {
                    $membership->increment('loyalty_point', $point);

                    LogActivityHelper::log(
                        "[LOYALTY POINT] Member: {$membership->nama_lengkap} | "
                        ."Tambah: {$point} point | "
                        ."Kode: {$transaksi->kode_tiket}"
                    );
                }
            }

            // =========================
            // 🔟 UPDATE AREA
            // =========================
            $detailArea = AreaParkirDetail::where('area_parkir_id', $transaksi->id_area)
                ->where('id_tipe_kendaraan', $kendaraan->id_tipe_kendaraan)
                ->lockForUpdate()
                ->firstOrFail();

            $tipe = TipeKendaraan::findOrFail($kendaraan->id_tipe_kendaraan);
            $detailArea->decrement('terisi', $tipe->kapasitas);

            DB::commit();

            LogActivityHelper::log(
                "[TRANSAKSI KELUAR] Kode: {$transaksi->kode_tiket} | "
                ."Plat: {$kendaraan->plat_nomor} | "
                ."Durasi: {$durasiJam} jam | "
                ."Total: Rp " . number_format($totalBayar, 0, ',', '.')
            );

            return redirect()
                ->route('transaksi.tiket-keluar', $transaksi->id)
                ->with('memberInfo', $memberInfo);
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
        $memberInfo = session('memberInfo');

        return view('transaksi.tiket-keluar', compact('transaksi', 'memberInfo'));
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
                ->editColumn('waktu_masuk', fn($row) => $row->waktu_masuk->format('Y-m-d H:i'))

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
                ->addColumn('aksi', function ($row) {
                    return '
                        <a href="'.route('transaksi.struk.masuk', $row->id).'"
                        class="text-blue-600 hover:underline text-sm">
                            Detail
                        </a>
                    ';
                })
                ->rawColumns(['status_badge', 'aksi'])
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
                ->editColumn('waktu_masuk', fn($row) => $row->waktu_masuk->format('Y-m-d H:i'))
                ->editColumn('waktu_keluar', fn($row) => $row->waktu_keluar->format('Y-m-d H:i'))

                ->orderColumn('plat', function ($query, $order) {
                    $query->join('tb_data_kendaraan as dk', 'dk.id', '=', 'tb_transaksi.id_data_kendaraan')
                        ->orderBy('dk.plat_nomor', $order);
                })
                ->filterColumn('plat', function ($query, $keyword) {
                    $query->whereExists(function ($sub) use ($keyword) {
                        $sub->select(DB::raw(1))
                            ->from('tb_data_kendaraan')
                            ->whereColumn('tb_data_kendaraan.id', 'tb_transaksi.id_data_kendaraan')
                            ->where('tb_data_kendaraan.plat_nomor', 'LIKE', "%{$keyword}%");
                    });
                })
                ->orderColumn('tipe', function ($query, $order) {
                    $query->join('tb_data_kendaraan as dk2', 'dk2.id', '=', 'tb_transaksi.id_data_kendaraan')
                        ->join('tb_tipe_kendaraan as tk', 'tk.id', '=', 'dk2.id_tipe_kendaraan')
                        ->orderBy('tk.tipe_kendaraan', $order);
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
                ->addColumn('status_badge', function ($row) {
                    return '<span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                        KELUAR
                    </span>';
                })
                ->addColumn('aksi', function ($row) {
                    return '
                        <a href="'.route('transaksi.struk', $row->id).'"
                        class="text-blue-600 hover:underline text-sm">
                            Detail
                        </a>
                    ';
                })
                ->rawColumns(['aksi', 'status_badge'])
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

    public function strukMasuk($id)
    {
        $transaksi = Transaksi::with([
            'dataKendaraan.tipeKendaraan',
            'areaParkir'
        ])
        ->where('status', 'masuk')
        ->findOrFail($id);

        return view('transaksi.struk-masuk', compact('transaksi'));
    }
}
