<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\AreaParkirController;
use App\Http\Controllers\TipeKendaraanController;
use App\Http\Controllers\DataKendaraanController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\MembershipTierController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\DatabaseBackupController;

use App\Http\Controllers\TrackAreaParkirController;

use App\Http\Controllers\TransaksiController;

use App\Http\Controllers\Laporan\LaporanController;
use App\Http\Controllers\Laporan\AnalyticsController;


/*
|-------------------------------------------------------------------------- 
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
        Route::resource('user', UserController::class);
        Route::resource('tarif', TarifController::class);
        Route::resource('area-parkir', AreaParkirController::class);
        Route::resource('tipe-kendaraan', TipeKendaraanController::class);
        Route::resource('data-kendaraan', DataKendaraanController::class);
        Route::resource('membership', MembershipController::class);
        Route::resource('membership-tier', MembershipTierController::class);
        Route::post('/membership/{membership}/redeem-point', [MembershipController::class, 'redeemPoint'])->name('membership.redeem-point');
        Route::get('/membership/{membership}/kendaraan',[MembershipController::class, 'kendaraanDatatable'])->name('membership.kendaraan');
        Route::get('/ajax/kendaraan', [MembershipController::class, 'searchKendaraan'])->name('ajax.kendaraan');
        Route::resource('diskon', DiskonController::class);
        Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log-aktivitas.index');

        Route::middleware(['auth'])->group(function () {
            Route::get('/database', [DatabaseBackupController::class, 'index'])
                ->name('database.index');

            Route::get('/database/export', [DatabaseBackupController::class, 'exportSql'])
                ->name('database.export.sql');

            Route::post('/database/import', [DatabaseBackupController::class, 'import'])
                ->name('database.import');
        });
    });

    Route::get('/track-area-parkir', [TrackAreaParkirController::class, 'index'])->name('track-area-parkir');
    Route::get('/tracking-area/data', [TrackAreaParkirController::class, 'data'])->name('tracking-area.data');
    Route::get('/monitoring-area-parkir',[TrackAreaParkirController::class, 'monitoring'])->name('monitoring-area-parkir');


    Route::middleware(['auth', RoleMiddleware::class . ':Petugas Parkir'])->group(function () {
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::post('/transaksi/masuk', [TransaksiController::class, 'masuk'])->name('transaksi.masuk');
        Route::get('/transaksi/tiket-masuk/{id}', [TransaksiController::class, 'tiketMasuk'])->name('transaksi.tiket-masuk');
        Route::post('/transaksi/keluar', [TransaksiController::class, 'keluar'])->name('transaksi.keluar');
        Route::get('/transaksi/tiket-keluar/{id}', [TransaksiController::class, 'tiketKeluar'])->name('transaksi.tiket-keluar');
        Route::get('/kendaraan/search', [DataKendaraanController::class, 'search']);
        Route::get('/area/by-tipe/{id}', [TransaksiController::class, 'getAreaByTipe']);
        });

        Route::get('/transaksi/aktif', [TransaksiController::class, 'aktif'])->name('transaksi.aktif');
        Route::get('/transaksi/riwayat', [TransaksiController::class, 'riwayat'])->name('transaksi.riwayat');
        Route::get('/transaksi/struk/{id}', [TransaksiController::class, 'struk'])->name('transaksi.struk');
        Route::get('/transaksi/masuk/{id}', [TransaksiController::class, 'strukMasuk'])->name('transaksi.struk.masuk');

    Route::middleware(['auth', RoleMiddleware::class . ':Owner/Manajemen'])->group(function () {
        Route::prefix('laporan')->middleware(['auth'])->group(function () {
            Route::get('/', [LaporanController::class, 'index'])->name('laporan.index');
            Route::get('/harian', [LaporanController::class, 'harian'])->name('laporan.harian');
            Route::get('/range', [LaporanController::class, 'range'])->name('laporan.range');
            Route::get('/range/data', [LaporanController::class, 'rangeData'])->name('laporan.range.data');

            Route::get('/analytics', [AnalyticsController::class, 'index'])->name('laporan.analytics');

            Route::get('/analytics/revenue', [AnalyticsController::class, 'revenue']);
            Route::get('/analytics/peak-hour', [AnalyticsController::class, 'peakHour']);
            Route::get('/analytics/member', [AnalyticsController::class, 'member']);
            Route::get('/analytics/vehicle', [AnalyticsController::class, 'vehicle']);
            Route::get('/analytics/payment', [AnalyticsController::class, 'payment']);
            Route::get('/analytics/occupancy', [AnalyticsController::class, 'occupancy']);

            Route::get('/analytics/export/csv', [AnalyticsController::class, 'exportCsv'])->name('laporan.analytics.csv');
        });
    });
});

require __DIR__.'/auth.php';
